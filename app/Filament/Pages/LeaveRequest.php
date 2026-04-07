<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\LeaveRequest as LeaveModel;
use Filament\Notifications\Notification;

class LeaveRequest extends Page
{
    protected string $view = 'filament.pages.leave-request';

    public $editingId = null;
    public $start_date;
    public $end_date;
    public $reason;

    // ✅ FIX DI SINI
    public function getRequestsProperty()
    {
        $user = auth()->user();

        $roles = $user->getRoleNames();

        // DEBUG (boleh sementara)
        // dd($roles);

        // hanya role tertentu boleh lihat semua
        if ($roles->contains('kepala divisi') ||
            $roles->contains('HR') ||
            $roles->contains('direktur')) {

            return LeaveModel::latest()->get();
        }

        // selain itu → hanya punya sendiri
        return LeaveModel::where('user_id', $user->id)
            ->latest()
            ->get();
    }

    public function edit($id)
    {
        $leave = LeaveModel::findOrFail($id);

        // ❗ staff hanya boleh edit punya sendiri
        if (auth()->user()->hasRole('staff') && $leave->user_id !== auth()->id()) {
            abort(403);
        }

        if ($leave->final_status !== 'pending') return;

        $this->editingId = $leave->id;
        $this->start_date = $leave->start_date;
        $this->end_date = $leave->end_date;
        $this->reason = $leave->reason;
    }

    public function update()
    {
        LeaveModel::where('id', $this->editingId)
            ->update([
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'reason' => $this->reason,
            ]);

        Notification::make()
            ->title('Request berhasil diupdate')
            ->success()
            ->send();

        $this->reset([
            'editingId',
            'start_date',
            'end_date',
            'reason'
        ]);
    }

    public function cancel($id)
    {
        $leave = LeaveModel::findOrFail($id);

        // ❗ staff hanya boleh cancel punya sendiri
        if (auth()->user()->hasRole('staff') && $leave->user_id !== auth()->id()) {
            abort(403);
        }

        if ($leave->final_status !== 'pending') return;

        $leave->delete();

        Notification::make()
            ->title('Request dibatalkan')
            ->success()
            ->send();
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
