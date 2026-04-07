<?php

namespace App\Filament\Resources\Repurchases\Pages;

use App\Filament\Resources\Repurchases\RepurchaseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRepurchases extends ListRecords
{
    protected static string $resource = RepurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
