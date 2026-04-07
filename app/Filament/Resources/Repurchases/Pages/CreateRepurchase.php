<?php

namespace App\Filament\Resources\Repurchases\Pages;

use App\Filament\Resources\Repurchases\RepurchaseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRepurchase extends CreateRecord
{
    protected static string $resource = RepurchaseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id(); // ⬅️ ini yang penting
        return $data;
    }
}
