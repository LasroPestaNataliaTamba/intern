<x-filament::page>

<div class="bg-white p-6 rounded-xl shadow mb-6">

    <h2 class="text-xl font-bold mb-5">Request Surat</h2>

    <form wire:submit.prevent="submit" enctype="multipart/form-data">

        <div class="grid gap-3">

            {{-- TYPE --}}
            <select wire:model="type" class="border p-2 rounded">
                <option value="">Pilih Jenis</option>
                <option value="keterangan">Surat Keterangan</option>
                <option value="rekomendasi">Surat Rekomendasi</option>
                <option value="pengantar">Surat Pengantar</option>
            </select>
            @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror


            {{-- PURPOSE --}}
            <textarea wire:model="purpose" placeholder="Keperluan" class="border p-2 rounded"></textarea>
            @error('purpose') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror


            {{-- DATE --}}
            <input type="date" wire:model="needed_date" class="border p-2 rounded">
            @error('needed_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror


            {{-- ATTACHMENT --}}
            <input type="file" wire:model="attachment" class="border p-2 rounded">
            @error('attachment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <div wire:loading wire:target="attachment" class="text-sm text-gray-500">
                Uploading...
            </div>

            <x-filament::button type="submit">
                Submit Request
            </x-filament::button>

        </div>

    </form>

</div>


<h3 class="font-bold text-lg mb-3">Request sebelumnya</h3>

<table class="w-full border">

    <tr class="bg-gray-100">
        <th class="border p-2">Jenis</th>
        <th class="border p-2">Keterangan</th>
        <th class="border p-2">Tanggal</th>
        <th class="border p-2">Status</th>
        <th class="border p-2">Aksi</th>
    </tr>

    @foreach($this->requests as $r)
    <tr>

        <td class="border p-2">{{ $r->type }}</td>

        <td class="border p-2">{{ $r->purpose }}</td>

        <td class="border p-2">{{ $r->needed_date }}</td>

        <td class="border p-2">
            @if($r->status === 'completed' && $r->processed_file)
                <a href="{{ asset('storage/'.$r->processed_file) }}" class="text-blue-600 underline">
                    Download
                </a>
            @elseif($r->status === 'rejected')
                <span class="text-red-600 font-bold">Ditolak</span>
            @else
                <span class="text-gray-500">Menunggu</span>
            @endif
        </td>

        <td class="border p-2">

            {{-- ADMIN --}}
            @if(auth()->check() && auth()->user()->role === 'administrasi')

                <button
                    wire:click="showDetail({{ $r->id }})"
                    class="text-green-600 font-semibold underline">
                    Detail
                </button>

            @else

                {{-- USER --}}
                @if($r->status === 'pending')
                    <button
                        wire:click="edit({{ $r->id }})"
                        class="text-blue-600 underline">
                        Edit
                    </button>
                @endif

            @endif

        </td>

    </tr>
    @endforeach

</table>


{{-- MODAL DETAIL --}}
@if($selectedRequest)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-xl w-[500px] shadow-lg">

        <h2 class="text-lg font-bold mb-4">Detail Request</h2>

        <div class="space-y-2 text-sm">

            <p><b>Nama:</b> {{ $selectedRequest->user->name }}</p>
            <p><b>Email:</b> {{ $selectedRequest->user->email }}</p>

            <hr>

            <p><b>Jenis:</b> {{ $selectedRequest->type }}</p>
            <p><b>Keterangan:</b> {{ $selectedRequest->purpose }}</p>
            <p><b>Tanggal:</b> {{ $selectedRequest->needed_date }}</p>

            @if($selectedRequest->attachment)
                <p>
                    <b>Lampiran:</b>
                    <a href="{{ asset('storage/'.$selectedRequest->attachment) }}"
                        class="text-blue-600 underline">
                        Lihat File
                    </a>
                </p>
            @endif

            <p><b>Status:</b> {{ $selectedRequest->status }}</p>

        </div>

        <div class="mt-5 flex justify-between">

            <button
                wire:click="closeDetail"
                class="px-3 py-1 bg-gray-300 rounded">
                Tutup
            </button>

            <div class="flex gap-2">

                <button
                    wire:click="rejectRequest({{ $selectedRequest->id }})"
                    class="px-3 py-1 bg-red-600 text-white rounded">
                    Reject
                </button>

                <a href="{{ url('/admin/process-document-request?record='.$selectedRequest->id) }}"
                    class="px-3 py-1 bg-green-600 text-white rounded">
                    Proses
                </a>

            </div>

        </div>

    </div>
</div>
@endif

</x-filament::page>
