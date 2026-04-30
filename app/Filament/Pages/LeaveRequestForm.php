<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use App\Models\LeaveRequest;

class LeaveRequestForm extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.pages.leave-request-form';

    public $id;
    public $name;
    public $start_date;
    public $end_date;
    public $reason;
    public $leave;
    public $isDetail = false;
    public $requests = [];
    public $sisa_cuti;

     protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->url(fn () => route('filament.admin.pages.leave-request', ['id' => $this->id])),
        ];
    }

     public function getRequestsProperty()
    {
        $user = auth()->user();

        if ($user->hasAnyRole(['kepala divisi', 'HR', 'direktur'])) {
            return LeaveRequest::latest()->get();
        }

        return LeaveRequest::where('user_id', $user->id)
            ->latest()
            ->get();
    }

    public function mount()
    {
        $id = request()->get('id');

        if ($id) {
        $leave = \App\Models\LeaveRequest::findOrFail($id);
        $user = auth()->user();

        // 🔒 proteksi akses
        if (
            !$user->hasAnyRole(['kepala divisi', 'HR', 'direktur']) &&
            $leave->user_id !== $user->id
        ) {
            abort(403);
        }

        if ($id) {
            $this->leave = \App\Models\LeaveRequest::findOrFail($id);

            $this->start_date = $this->leave->start_date;
            $this->end_date = $this->leave->end_date;
            $this->reason = $this->leave->reason;
            $this->name = $this->leave->name;
            $this->sisa_cuti = $this->leave->sisa_cuti;

            $this->isDetail = true;
        }
    }
    }

    public function submit()
    {
        \App\Models\LeaveRequest::create([
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'sisa_cuti' => $this->sisa_cuti, // ❗ FIX: hitung sisa cuti berdasarkan tanggal
            'reason' => $this->reason,

            'division_status' => 'pending',
            'hr_status' => 'pending',
            'director_status' => 'pending',
            'final_status' => 'pending',
        ]);

        \Filament\Notifications\Notification::make()
            ->title('Request cuti berhasil dikirim')
            ->success()
            ->send();

        return redirect()->route('filament.admin.pages.leave-request');
    }

    public function approve()
    {
        $user = auth()->user();

        if ($user->hasRole('kepala divisi')) {
            $this->leave->update(['division_status' => 'approved']);
        }

        if ($user->hasRole('HR')) {
            $this->leave->update(['hr_status' => 'approved']);
        }

        if ($user->hasRole('direktur')) {
            $this->leave->update(['director_status' => 'approved']);
        }

        // ✅ cek kalau semua sudah approve
        if (
            $this->leave->division_status == 'approved' &&
            $this->leave->hr_status == 'approved' &&
            $this->leave->director_status == 'approved'
        ) {
            $this->leave->update(['final_status' => 'approved']);
        }
    }

    public function reject()
    {
        if (!auth()->user()->hasAnyRole(['kepala divisi','HR','direktur'])) {
            abort(403);
        }

        $this->leave->update([
            'final_status' => 'rejected'
        ]);

        Notification::make()
            ->title('Cuti ditolak')
            ->danger()
            ->send();
    }
}
