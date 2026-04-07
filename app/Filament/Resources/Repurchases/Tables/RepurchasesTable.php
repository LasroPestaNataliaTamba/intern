<?php

namespace App\Filament\Resources\Repurchases\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;


class RepurchasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),

                TextColumn::make('item_name')
                    ->label('Item')
                    ->searchable(),

                TextColumn::make('qty'),

                TextColumn::make('price')
                    ->money('IDR', true),

                TextColumn::make('total')
                    ->money('IDR', true),

                TextColumn::make('supplier'),

                TextColumn::make('bank_account'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->actions([
                // 👀 Semua bisa lihat detail (user lihat miliknya, finance lihat semua)
                ViewAction::make(),

                // ✏️ Edit hanya untuk user & pending
                EditAction::make()
                    ->visible(fn ($record) =>
                        auth()->user()->role === 'user'
                        && $record->user_id === auth()->id()
                        && $record->status === 'pending'
                    ),
            ]);

    }
}
