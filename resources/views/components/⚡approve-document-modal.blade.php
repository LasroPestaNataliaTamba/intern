<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DocumentRequest;

new class extends Component
{
    use WithFileUploads;

    public $show = false;
    public $requestId;
    public $file;

    protected $listeners = ['openApproveModal'];

    public function openApproveModal($data)
    {
        $this->requestId = $data['id'];
        $this->show = true;
    }

    public function approve()
    {
        if (!$this->file) return;

        $path = $this->file->store('processed-documents','public');

        DocumentRequest::find($this->requestId)->update([
            'status' => 'approved',
            'processed_file' => $path
        ]);

        $this->reset();

        $this->dispatch('close-modal');
    }
};
?>

<div>

@if($show)

<div class="fixed inset-0 bg-black/40 flex items-center justify-center">

<div class="bg-white p-6 rounded shadow w-96">

<h2 class="font-bold mb-3">Upload Surat</h2>

<input type="file" wire:model="file">

<button
wire:click="approve"
class="bg-green-600 text-white px-3 py-1 rounded mt-3"
>
Submit
</button>

<button
wire:click="$set('show', false)"
class="bg-gray-400 text-white px-3 py-1 rounded mt-3"
>
Cancel
</button>

</div>

</div>

@endif

</div>
