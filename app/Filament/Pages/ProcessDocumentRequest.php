<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\DocumentRequest;
use Livewire\WithFileUploads;
use Filament\Notifications\Notification;

class ProcessDocumentRequest extends Page
{
    use WithFileUploads;

    protected static string|\BackedEnum|null $navigationIcon = null;

    protected static ?string $slug = 'process-document-request';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.pages.process-document-request';

    public ?DocumentRequest $recordModel = null;

    public $file;

    public function mount()
    {
        if (auth()->user()->role !== 'administrasi') {
            abort(403);
        }

        $recordId = request()->get('record');

        if (!$recordId) {
            abort(404);
        }

        $this->recordModel = DocumentRequest::with('user')->find($recordId);

        if (!$this->recordModel) {
            abort(404);
        }
    }

    public function submit()
    {
        $this->validate([
            'file' => 'required|file|max:10240',
        ]);

        $filePath = $this->file->store('processed', 'public');

        $this->recordModel->update([
            'status' => 'completed',
            'processed_file' => $filePath,
        ]);

        Notification::make()
            ->title('Dokumen berhasil diproses')
            ->success()
            ->send();

        return redirect('/admin/document-request-page');
    }

    public function reject()
    {
        $this->recordModel->update([
            'status' => 'rejected'
        ]);

        Notification::make()
            ->title('Request ditolak')
            ->danger()
            ->send();

        return redirect('/admin/document-request-page');
    }
}
