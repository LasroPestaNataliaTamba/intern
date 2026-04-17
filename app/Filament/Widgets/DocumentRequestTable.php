<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\TextColumn;
use App\Models\DocumentRequest;

class DocumentRequestTable extends TableWidget
{
    protected static ?string $heading = 'Daftar Pengajuan Dokumen';

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('direktur') ?? false;
    }

    public function table(Table $table): Table
    {
        $user = auth()->user();

        return $table
            ->query(
                DocumentRequest::query()
                    ->when(
                        !$user || !$user->hasAnyRole(['direktur', 'administrasi']),
                        fn ($query) => $query->where('user_id', $user?->id ?? 0)
                    )
                    ->latest()
            )
            ->columns($this->getTableColumns());
    }

    protected function getTableColumns(): array
    {
        $user = auth()->user();

        if ($user?->hasRole('direktur')) {
            return [
                TextColumn::make('user.name')
                    ->label('Nama Pengaju')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('needed_date')
                    ->label('Tanggal Dibutuhkan')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('purpose')
                    ->label('Keperluan')
                    ->limit(50)
                    ->tooltip(fn ($state) => $state)
                    ->searchable()
                    ->sortable(),
            ];
        }

        return [
            TextColumn::make('needed_date')
                ->label('Tanggal Dibutuhkan')
                ->date('d M Y')
                ->sortable(),

            TextColumn::make('purpose')
                ->label('Keperluan')
                ->limit(50)
                ->tooltip(fn ($state) => $state)
                ->searchable()
                ->sortable(),
        ];
    }
}
