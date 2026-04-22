<x-filament::page>

<h2 class="text-xl font-bold mb-4">Detail Request</h2>

<div class="mb-4 space-y-2">
    <p><b>Nama:</b> {{ $recordModel->user->name }}</p>
    <p><b>Email:</b> {{ $recordModel->user->email }}</p>
    <p><b>Jenis:</b> {{ $recordModel->type }}</p>
    <p><b>Keperluan:</b> {{ $recordModel->purpose }}</p>
    <p><b>Tanggal:</b> {{ $recordModel->needed_date }}</p>
    <p><b>Sisa Cuti:</b> {{ $recordModel->sisa_cuti }}</p>

    <a href="{{ asset('storage/'.$recordModel->attachment) }}"
       class="text-blue-600 underline">
        Download Lampiran
    </a>
</div>

<form wire:submit.prevent="submit">

    <input type="file" wire:model="file" class="mb-3">

    @error('file')
        <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror

    <div class="flex gap-3 mt-3">

        <!-- ✅ APPROVE -->
        <button type="submit"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Approve
        </button>

        <!-- ❌ REJECT -->
        <button type="button"
            wire:click="reject"
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Reject
        </button>

    </div>

</form>

</x-filament::page>
