<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Repurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FinanceStats extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();

        // 💰 Query dasar
        $query = Repurchase::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        // 🔒 Filter hanya untuk user biasa
        if (!in_array($user->role, ['finance', 'direktur'])) {
            $query->where('user_id', $user->id);
        }

        $pengeluaran = $query->sum('total');

        // 🔥 LABEL DINAMIS
        $label = in_array($user->role, ['finance', 'direktur'])
            ? 'Total Pengeluaran Bulan Ini'
            : 'Pengeluaran Saya Bulan Ini';

        // 🏖️ Cuti
        $cuti = DB::table('leave_requests')
            ->where('user_id', $user->id)
            ->count();

        return [
            Stat::make($label, 'Rp ' . number_format($pengeluaran, 0, ',', '.')),
            Stat::make('Cuti Saya', $cuti),
        ];
    }

    // 🔥 FIX DI SINI (WAJIB STATIC)
    public static function canView(): bool
    {
        return auth()->user()?->role === 'finance';
    }
}
