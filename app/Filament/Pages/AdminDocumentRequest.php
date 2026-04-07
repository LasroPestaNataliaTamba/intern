<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\DocumentRequest;

class AdminDocumentRequest extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Admin Document Request';

    protected static ?string $slug = 'admin-document-request';

    protected string $view = 'filament.pages.admin-document-request';

    public function getRequestsProperty()
    {
        return DocumentRequest::all();
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'administrasi';
    }
}
