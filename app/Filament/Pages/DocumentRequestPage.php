<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\DocumentRequest;
use Livewire\WithFileUploads;
use Filament\Notifications\Notification;

class DocumentRequestPage extends Page
{
    use WithFileUploads;

    protected string $view = 'filament.pages.document-request-page';

    public $type;
    public $purpose;
    public $needed_date;
    public $attachment;
    public $editId = null;
    public $selectedRequest = null;

    public function getRequestsProperty()
    {
        $user = auth()->user();

        // kalau belum login
        if (!$user) {
            return collect();
        }

        // 🧑‍💼 ADMIN → lihat semua
        if ($user->role === 'administrasi') {
            return DocumentRequest::with('user')
                ->latest()
                ->get();
        }

        // 👤 USER → hanya miliknya
        return DocumentRequest::where('user_id', $user->id)
            ->latest()
            ->get();
    }

    public function submit()
    {
        $this->validate([
            'type' => 'required',
            'purpose' => 'required',
            'needed_date' => 'required|date',
            'attachment' => $this->editId ? 'nullable|file|max:2048' : 'required|file|max:2048',
        ]);

        $filePath = null;

        if ($this->attachment) {
            $filePath = $this->attachment->store('attachments', 'public');
        }

        if ($this->editId) {
            $request = DocumentRequest::findOrFail($this->editId);

            // 🔒 user tidak boleh edit punya orang lain
            if (
                auth()->user()->role !== 'administrasi' &&
                $request->user_id !== auth()->id()
            ) {
                abort(403);
            }

            $request->update([
                'type' => $this->type,
                'purpose' => $this->purpose,
                'needed_date' => $this->needed_date,
                'attachment' => $filePath ?? $request->attachment,
            ]);

            Notification::make()
                ->title('Request berhasil diupdate')
                ->success()
                ->send();

        } else {
            DocumentRequest::create([
                'user_id' => auth()->id(),
                'type' => $this->type,
                'purpose' => $this->purpose,
                'needed_date' => $this->needed_date,
                'status' => 'pending',
                'attachment' => $filePath,
            ]);

            Notification::make()
                ->title('Request berhasil dikirim')
                ->success()
                ->send();
        }

        $this->reset(['type','purpose','needed_date','attachment','editId']);
    }

    public function edit($id)
    {
        $data = DocumentRequest::findOrFail($id);

        // 🔒 proteksi edit
        if (
            auth()->user()->role !== 'administrasi' &&
            $data->user_id !== auth()->id()
        ) {
            abort(403);
        }

        $this->editId = $data->id;
        $this->type = $data->type;
        $this->purpose = $data->purpose;
        $this->needed_date = $data->needed_date;
    }

    public function showDetail($id)
    {
        $this->selectedRequest = \App\Models\DocumentRequest::with('user')->find($id);
    }
}
