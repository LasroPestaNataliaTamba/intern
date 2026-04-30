<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email'),

                Tables\Columns\TextColumn::make('roles.name')->badge(),
                Tables\Columns\TextColumn::make('division.name')->searchable(),
                Tables\Columns\TextColumn::make('company.name')->searchable(),

                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ]);
    }
}
