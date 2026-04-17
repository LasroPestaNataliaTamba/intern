<?php

namespace App\Filament\Resources\Repurchases;

use App\Filament\Resources\Repurchases\Pages\CreateRepurchase;
use App\Filament\Resources\Repurchases\Pages\EditRepurchase;
use App\Filament\Resources\Repurchases\Pages\ListRepurchases;
use App\Filament\Resources\Repurchases\Pages\ViewRepurchase;
use App\Filament\Resources\Repurchases\Schemas\RepurchaseForm;
use App\Models\Repurchase;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\Action;

class RepurchaseResource extends Resource
{
    protected static ?string $navigationLabel = 'Repurchase';
    protected static ?string $pluralLabel = 'Repurchase';
    protected static ?string $model = Repurchase::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $recordTitleAttribute = 'item_name';

    public static function form(Schema $schema): Schema
    {
        return RepurchaseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),

                // 🔥 TAMPILKAN PENGIRIM
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable(),

                TextColumn::make('item_name')->label('Item'),

                TextColumn::make('qty'),

                TextColumn::make('price'),

                TextColumn::make('total'),

                TextColumn::make('supplier'),

                TextColumn::make('created_at')->dateTime(),

                TextColumn::make('status')
                ->badge()
                ->formatStateUsing(fn ($state) => match ($state) {
                    'pending' => 'Pending',
                    'approved_finance' => 'Waiting Director Approval',
                    'approved_director' => 'Approved',
                    'rejected' => 'Rejected',
                    default => $state,
                })
                ->colors([
                    'warning' => 'pending',
                    'info' => 'approved_finance',
                    'success' => 'approved_director',
                    'danger' => 'rejected',
                ]),
            ])
            ->actions([

                // ✅ EDIT (HANYA OWNER + PENDING)
                EditAction::make()
                    ->visible(fn ($record) =>
                        auth()->check()
                        && $record->user_id === auth()->id()
                        && $record->status === 'pending'
                    ),

                // ✅ APPROVE
                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->visible(fn ($record) =>
                        auth()->user()?->hasAnyRole(['finance', 'direktur'])
                        && $record->status === 'pending'
                    )
                    ->action(function ($record) {
                        abort_unless(
                            auth()->user()?->hasAnyRole(['finance', 'direktur']),
                            403
                        );

                        $record->update([
                            'status' => 'approved',
                        ]);
                    }),

                // ✅ REJECT
                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->visible(fn ($record) =>
                        auth()->user()?->hasAnyRole(['finance', 'direktur'])
                        && $record->status === 'pending'
                    )
                    ->action(function ($record) {
                        abort_unless(
                            auth()->user()?->hasAnyRole(['finance', 'direktur']),
                            403
                        );

                        $record->update([
                            'status' => 'rejected',
                        ]);
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRepurchases::route('/'),
            'create' => CreateRepurchase::route('/create'),
            'view' => ViewRepurchase::route('/{record}'),
            'edit' => EditRepurchase::route('/{record}/edit'),
        ];
    }

    // ✅ FILTER DATA BERDASARKAN ROLE (SPATIE)
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        $query = parent::getEloquentQuery();

        // ✅ DIREKTUR & FINANCE → lihat semua
        if ($user->hasAnyRole(['direktur', 'finance'])) {
            return $query;
        }

        // ✅ USER → hanya data miliknya sendiri
        return $query->where('user_id', $user->id);
    }

    // ✅ PROTEKSI EDIT
    public static function canEdit($record): bool
    {
        return auth()->check()
            && $record->user_id === auth()->id()
            && $record->status === 'pending';
    }
}
