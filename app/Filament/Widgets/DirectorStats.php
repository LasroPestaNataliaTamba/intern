<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\LeaveRequest;
use App\Models\Repurchase;
use Illuminate\Database\Eloquent\Builder;

class DirectorStats extends StatsOverviewWidget
{

    protected function getStats(): array
    {
        $user = auth()->user();
        $role = trim(strtolower($user->role));

        if ($role === 'direktur') {
            $leaveQuery = LeaveRequest::withoutGlobalScopes();
            $repurchaseQuery = Repurchase::withoutGlobalScopes();
        }

        elseif ($role === 'HR') {
            $leaveQuery = LeaveRequest::withoutGlobalScopes();

            $repurchaseQuery = Repurchase::withoutGlobalScopes()
                ->where('user_id', $user->id)
                ->where('status', 'approved');
        }

        elseif ($role === 'finance') {
            $leaveQuery = LeaveRequest::withoutGlobalScopes();
            $repurchaseQuery = Repurchase::withoutGlobalScopes();
        }

        else {
            $leaveQuery = LeaveRequest::where('user_id', $user->id);
            $repurchaseQuery = Repurchase::where('user_id', $user->id);
        }

        return [

            Stat::make(
                'Menunggu persetujuan',
                function () use ($leaveQuery) {
                    $user = auth()->user();

                    $query = (clone $leaveQuery)
                        ->where('final_status', 'pending');

                    // Role yang boleh lihat SEMUA
                    if (!$user->hasAnyRole(['direktur', 'HR', 'kepala divisi'])) {
                        $query->where('user_id', $user->id);
                    }

                    return $query->count();
                }
            ),
            Stat::make(
                'Cuti hari ini',
                function () use ($leaveQuery) {
                    $user = auth()->user();

                    $query = (clone $leaveQuery)
                        ->where('final_status', 'approved')
                        ->whereDate('start_date', '<=', now())
                        ->whereDate('end_date', '>=', now());

                    // Role yang boleh lihat SEMUA
                    if (!$user->hasAnyRole(['direktur', 'HR', 'kepala divisi'])) {
                        $query->where('user_id', $user->id);
                    }

                    return $query->count();
                }
            ),
            Stat::make(
                 'Repurchase Tertunda ',
                    function () {
                        $user = auth()->user();
                           $query = \App\Models\Repurchase::whereNotIn('status', ['approved', 'rejected']);

                            if (!($user->hasRole('direktur') || $user->hasRole('finance'))) {
                                $query->where('user_id', $user->id);
                            }
                       return $query->count();
                }
        ),

            Stat::make(
                'Total Pengeluaran',
                function () {
                    $user = auth()->user();

                    $query = Repurchase::where('status', 'approved');

                    // hanya direktur & finance yang lihat semua
                    if (!($user->hasRole('direktur') || $user->hasRole('finance'))) {
                        $query->where('user_id', $user->id);
                    }

                    return 'Rp ' . number_format(
                        $query->sum('total'),
                        0,
                        ',',
                        '.'
                    );
                }
            )
        ];
    }

    protected function getTableQuery(): Builder
    {
        $user = auth()->user();
        $role = trim(strtolower($user->role));

        if ($role === 'direktur') {
            $leaveQuery = LeaveRequest::withoutGlobalScopes();
            $repurchaseQuery = Repurchase::withoutGlobalScopes();
        }

        elseif ($role === 'HR') {
            $leaveQuery = LeaveRequest::withoutGlobalScopes();

            $repurchaseQuery = Repurchase::withoutGlobalScopes()
                ->where('user_id', $user->id)
                ->where('status', 'approved');
        }

        elseif ($role === 'finance') {
            $leaveQuery = LeaveRequest::withoutGlobalScopes();
            $repurchaseQuery = Repurchase::withoutGlobalScopes();
        }

        else {
            $leaveQuery = LeaveRequest::where('user_id', $user->id);
            $repurchaseQuery = Repurchase::where('user_id', $user->id);
        }

        return LeaveRequest::withoutGlobalScopes();
    }
}
