<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;

class UsersTable
{
    public static function table(Table $table): Table
    {
        return $table->columns([

            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('email'),

            Tables\Columns\TextColumn::make('roles.name')
                ->badge(),

            Tables\Columns\IconColumn::make('is_active')
                ->boolean(),

        ])
        ->actions([

            Tables\Actions\EditAction::make(),

            // 🔐 RESET PASSWORD
            Tables\Actions\Action::make('resetPassword')
                ->form([
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->required(),
                ])
                ->action(function ($record, $data) {
                    $record->update([
                        'password' => $data['password'], // auto hash
                    ]);
                }),

        ]);
    }
}
