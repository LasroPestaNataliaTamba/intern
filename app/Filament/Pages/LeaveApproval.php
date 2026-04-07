<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\LeaveRequest;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class LeaveApproval extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckCircle;

    protected static ?string $slug = 'leave-approval/{id}';

    protected string $view = 'filament.pages.leave-approval';

    protected static bool $shouldRegisterNavigation = false;

    public $selected = null;

    public $id;
    public $request;

    /*
    |--------------------------------------------------------------------------
    | SEMUA APPROVER LIHAT HISTORI REQUEST
    |--------------------------------------------------------------------------
    */

    public function mount($id)
    {
        $this->id = $id;
        $this->request = \App\Models\LeaveRequest::findOrFail($id);
    }

    public function getRequestsProperty()
    {
        return LeaveRequest::with('user')
            ->latest()
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | HANYA ROLE INI YANG BOLEH MASUK PAGE
    |--------------------------------------------------------------------------
    */

    public static function canAccess(): bool
    {
        return auth()->user()->hasAnyRole([
            'kepala divisi',
            'HR',
            'direktur'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SELECT DETAIL
    |--------------------------------------------------------------------------
    */

    public function select($id)
    {
        $this->selected = LeaveRequest::findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE FLOW
    |--------------------------------------------------------------------------
    */

    public function approve()
    {
        if (!$this->selected) return;

        $user = auth()->user();

            if ($user->hasRole('kepala divisi')) {
            $this->selected->division_status = 'approved';
        }

        elseif ($user->hasRole('HR')) {
            $this->selected->hr_status = 'approved';
        }

        elseif ($user->hasRole('direktur')) {
            $this->selected->director_status = 'approved';
        }

        // FINAL APPROVED
        if (
            $this->selected->division_status === 'approved' &&
            $this->selected->hr_status === 'approved' &&
            $this->selected->director_status === 'approved'
        ) {
            $this->selected->final_status = 'approved';
        }

        $this->selected->save();

        Notification::make()
            ->title('Request Approved')
            ->success()
            ->send();

        $this->selected = null;
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT FLOW
    |--------------------------------------------------------------------------
    */

    public function reject()
    {
        if (!$this->selected) return;

        $user = auth()->user();

        if ($user->hasRole('kepala divisi')) {
            $this->selected->division_status = 'rejected';
        }

        elseif ($user->hasRole('HR')) {
            $this->selected->hr_status = 'rejected';
        }

        elseif ($user->hasRole('direktur')) {
            $this->selected->director_status = 'rejected';
        }

        // AUTO FINAL REJECT
        $this->selected->final_status = 'rejected';

        $this->selected->save();

        Notification::make()
            ->title('Request Ditolak')
            ->danger()
            ->send();

        $this->selected = null;
    }
}
