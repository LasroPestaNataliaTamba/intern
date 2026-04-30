<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    // ✅ FORM
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->required(),

            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\TextInput::make('password')
                ->password()
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn (string $context) => $context === 'create')
                ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null),

            Forms\Components\Select::make('roles')
                ->label('Role')
                ->multiple(false)
                ->relationship('roles', 'name')
                ->preload()
                ->required(),

            Forms\Components\Select::make('division_id')
                ->relationship('division', 'name')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\Select::make('company_id')
                ->relationship('company', 'name')
                ->searchable()
                ->preload(),
        ]);
    }

    // ✅ TABLE (PAKAI CLASS TERPISAH)
    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('admin');
    }
}
