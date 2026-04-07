<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Absence;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Filament\Notifications\Notification;
use App\Models\User;
use Livewire\Attributes\On;

class Attendance extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckCircle;

    protected string $view = 'filament.pages.attendance';

    public $today;

    public function mount()
    {
        $this->loadToday();
    }

    public function loadToday()
    {
        $this->today = Absence::where('user_id', auth()->id())
            ->whereDate('date', today())
            ->first();
    }

    // 🔥 CHECK IN (HANYA SATU FUNCTION)
    #[On('checkInLocation')]
    public function checkIn($lat, $lng)
    {
        if ($this->today) {

            Notification::make()
                ->title('Sudah absen hari ini')
                ->danger()
                ->send();

            return;
        }

        $status = now()->format('H:i') > '08:00'
            ? 'late'
            : 'on_time';

        Absence::create([
            'user_id' => auth()->id(),
            'date' => today(),
            'check_in' => now(),
            'status' => $status,
            'latitude' => $lat,
            'longitude' => $lng,
        ]);

        $this->loadToday();

        Notification::make()
            ->title('Check in berhasil')
            ->success()
            ->send();
    }

    // 🔥 CHECK OUT
    public function checkOut()
    {
        if (!$this->today) return;

        $this->today->update([
            'check_out' => now()
        ]);

        $this->loadToday();

        Notification::make()
            ->title('Check out berhasil')
            ->success()
            ->send();
    }

    // 🔥 HISTORY (ROLE BASED)
    public function getHistoryProperty()
    {
        $user = auth()->user();

        if ($user->hasAnyRole(['HR', 'direktur'])) {
            return Absence::with('user')->latest()->get();
        }

        return Absence::where('user_id', $user->id)
            ->latest()
            ->get();
    }

    // 🔥 SEMUA ABSENSI HARI INI (UNTUK HR & DIREKTUR)
    public function getTodayAttendancesProperty()
    {
        return Absence::with('user')
            ->whereDate('date', today())
            ->get();
    }

    // 🔥 BELUM ABSEN
    public function getNotCheckedInProperty()
    {
        $checkedInIds = Absence::whereDate('date', today())
            ->pluck('user_id');

        return User::whereNotIn('id', $checkedInIds)->get();
    }

    // 🔥 BELUM CHECK OUT
    public function getNotCheckedOutProperty()
    {
        return Absence::with('user')
            ->whereDate('date', today())
            ->whereNull('check_out')
            ->get();
    }
}
