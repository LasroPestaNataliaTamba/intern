<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use App\Models\Absence;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsencePie extends ChartWidget
{

    protected function getData(): array
    {
        $user = Auth::user();

        // 🔥 HARI INI
        $today = now()->toDateString();

        if ($user->hasRole(['direktur', 'HR'])) {

            // 🔥 Semua user
            $totalUsers = User::count();

            // 🔥 Data hari ini
            $todayAbsences = Absence::whereDate('date', $today)->get();

            $present = $todayAbsences->where('status', 'present')->count();
            $late = $todayAbsences->where('status', 'late')->count();

            // 🔥 Cuti hari ini
            $leave = LeaveRequest::where('final_status', 'approved')
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->count();

            // 🔥 Tidak absen = total user - yang masuk - cuti
            $tidakAbsen = max($totalUsers - ($present + $late + $leave), 0);

            return [
                'datasets' => [
                    [
                        'data' => [$leave, $tidakAbsen, $late, $present],
                        'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                    ],
                ],
                'labels' => ['Cuti', 'Tidak Absen', 'Telat', 'Tepat Waktu'],
            ];
        }

        // 🔥 STAFF → HITUNG PER BULAN
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        // 🔥 Hitung hari kerja
        $totalWorkingDays = 0;
        $current = $start->copy();

        while ($current <= $end) {
            if ($current->isWeekday()) {
                $totalWorkingDays++;
            }
            $current->addDay();
        }

        // 🔥 Data absensi user
        $absences = Absence::where('user_id', $user->id)
            ->whereBetween('date', [$start, $end])
            ->get();

        $late = $absences->where('status', 'late')->count();
        $present = $absences->where('status', 'present')->count();

        // 🔥 Tidak absen = hari kerja - hari masuk
        $tidakAbsen = max($totalWorkingDays - $absences->count(), 0);

        return [
            'datasets' => [
                [
                    'data' => [$tidakAbsen, $late, $present],
                    'backgroundColor' => ['#36A2EB', '#FFCE56', '#4BC0C0'],
                ],
            ],
            'labels' => ['Tidak Absen', 'Telat', 'Tepat Waktu'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
