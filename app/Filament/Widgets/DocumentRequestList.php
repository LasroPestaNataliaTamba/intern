<?php

namespace App\Filament\Widgets;

use App\Models\DocumentRequest;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class DocumentRequestList extends BaseWidget
{
    protected static ?string $heading = 'Request Dokumen';

    public static function canView(): bool
    {
        $user = Auth::user();

        return $user && $user->hasAnyRole(['administrasi', 'direktur']);
    }

    protected function getTableQuery(): Builder
    {
        return DocumentRequest::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('user.name')->label('Nama'),
            TextColumn::make('type')->label('Jenis'),
            TextColumn::make('purpose')->label('Keterangan'),
        ];
    }
}
