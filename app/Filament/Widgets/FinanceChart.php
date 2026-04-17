<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Repurchase;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinanceChart extends ChartWidget
{
    protected ?string $heading = 'Finance Chart';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $user = auth()->user();

        // ✅ BASE QUERY (SUDAH DI FILTER STATUS)
        $baseQuery = Repurchase::whereYear('created_at', now()->year)
            ->whereIn('status', ['approved', 'completed']); // 🔥 FIX

        // 🔒 USER BIASA → hanya data sendiri
        if (!$user->hasAnyRole(['finance', 'direktur'])) {
            $baseQuery->where('user_id', $user->id);
        }

        // 🔥 TOTAL
        $totalAll = (clone $baseQuery)->sum('total');

        // 🔥 DATA PER BULAN
        $data = (clone $baseQuery)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $months = [];
        $totals = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::create()->month($i)->format('M');
            $totals[] = $data[$i] ?? 0;
        }

        // 🔥 HEADING DINAMIS
        if ($user->hasAnyRole(['finance', 'direktur'])) {
            $this->heading = 'Total Semua Pengeluaran: Rp ' . number_format($totalAll, 0, ',', '.');
        } else {
            $this->heading = 'Pengeluaran Kamu: Rp ' . number_format($totalAll, 0, ',', '.');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pengeluaran per Bulan',
                    'data' => $totals,
                ],
            ],
            'labels' => $months,
        ];
    }
}
