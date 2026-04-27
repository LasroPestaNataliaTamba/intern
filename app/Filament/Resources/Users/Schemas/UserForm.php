<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms;
use Spatie\Permission\Models\Role;
use App\Models\Division;
use Filament\Forms\Components\Select;


class UserForm
{

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),

                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(),

                Forms\Components\Select::make('roles')
                    ->label('Role')
                    ->multiple()
                    ->options(Role::pluck('name', 'name'))
                    ->required(),

                Forms\Components\Select::make('division_id')
                    ->label('Division')
                    ->options(Division::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('company_id')
                    ->label('Company')
                    ->options(function () {
                        return auth()->user()->company ? [auth()->user()->company->id => auth()->user()->company->name] : [];
                    })
                    ->searchable()
                    ->required(),

            ]);
    }
}
