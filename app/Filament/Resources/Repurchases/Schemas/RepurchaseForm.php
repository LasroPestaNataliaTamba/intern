<?php

namespace App\Filament\Resources\Repurchases\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Components\TextEntry;

class RepurchaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('item_name')->required(),

                TextInput::make('qty')->numeric()->required(),

                TextInput::make('price')->numeric()->required(),

                TextInput::make('total')->numeric()->required(),

                TextInput::make('supplier')->required(),

                FileUpload::make('proof_pdf')
                    ->disk('public')
                    ->directory('repurchase')
                    ->acceptedFileTypes(['application/pdf'])
                    ->openable() // 🔥 INI PENTING
                    ->downloadable(), // optional

                TextEntry::make('proof_pdf')
                    ->label('Proof PDF')
                    ->url(fn ($record) => $record?->proof_pdf
                        ? asset('storage/' . $record->proof_pdf)
                        : null)
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => filled($record?->proof_pdf)),

                TextInput::make('bank_account')->required(),

            ]);
    }
}
