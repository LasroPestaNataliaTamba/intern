<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Table; // ✅ WAJIB
use App\Models\LeaveRequest;

class LeaveRequestTable extends BaseWidget
{
    protected static ?string $heading = 'Daftar Pengajuan Cuti';
    public static function canView(): bool
    {
        return auth()->user()?->hasRole('direktur') ?? false;
    }

    public function table(Table $table): Table
    {
        $user = auth()->user();

        return $table
            ->query(
                LeaveRequest::query()
                    ->when(
                        !$user || !$user->hasAnyRole(['direktur', 'HR', 'kepala divisi']),
                        fn ($query) => $query->where('user_id', $user?->id ?? 0)
                    )
                    ->latest()
            )
            ->columns($this->getTableColumns());
    }

    protected function getTableColumns(): array
    {
        $user = auth()->user();

        // 👑 Direktur → full akses
        if ($user?->hasRole('direktur')) {
            return [
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pengaju')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Mulai Cuti')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('Selesai Cuti')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('final_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
            ];
        }

        // 👤 Selain direktur → versi sederhana
        return [
            Tables\Columns\TextColumn::make('start_date')
                ->label('Mulai Cuti')
                ->date('d M Y')
                ->sortable(),

            Tables\Columns\TextColumn::make('end_date')
                ->label('Selesai Cuti')
                ->date('d M Y')
                ->sortable(),

            Tables\Columns\TextColumn::make('final_status')
                ->label('Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'approved' => 'success',
                    'rejected' => 'danger',
                    default => 'gray',
                }),
        ];
    }
}
