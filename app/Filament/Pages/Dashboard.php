<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $slug = 'dashboard';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\DirectorStats::class,
            \App\Filament\Widgets\AbsencePie::class,
            \App\Filament\Widgets\FinanceChart::class,
            \App\Filament\Widgets\LeaveRequestTable::class,
            \App\Filament\Widgets\DocumentRequestTable::class,
        ];
    }
}
