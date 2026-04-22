<x-filament::page>

@php
    $user = auth()->user();
    $isApprover = in_array(strtolower($user->role), ['hr','headdivision','direktur']);
    $isStaff = $user->role === 'staff';
@endphp

<x-filament::button
    color="success"
    tag="a"
    href="{{ route('filament.admin.pages.leave-request-form') }}">
    Request Cuti
</x-filament::button>

<br><br>

<table class="w-full border rounded-lg overflow-hidden">

<tr class="bg-gray-100 text-left">
    <th class="border p-3">No</th>

    @if($isApprover)
        <th class="border p-3">Nama</th>
    @endif

    <th class="border p-3">Status</th>
    <th class="border p-3">Tanggal</th>
    <th class="border p-3">Sisa Cuti</th>
    <th class="border p-3">Alasan</th>
    <th class="border p-3">Aksi</th>
</tr>

@forelse($this->requests as $r)

<tr class="border-b">

<td class="border p-3">
    {{ $loop->iteration }}
</td>

@if($isApprover)
<td class="border p-3">
    {{ $r->user->name ?? '-' }}
</td>
@endif

<td class="border p-3">
@if($r->final_status == 'approved')
    <span class="text-green-600 font-bold">Approved</span>
@elseif($r->final_status == 'rejected')
    <span class="text-red-600 font-bold">Rejected</span>
@else
    <span class="text-yellow-600 font-bold">
        Waiting for Approval
    </span>
@endif
</td>

<td class="border p-3">
    {{ $r->start_date }} - {{ $r->end_date }}
</td>

<td class="border p-3">
    {{ $r->reason }}
</td>

<td class="border p-3 space-x-2">

{{-- ✅ BUTTON DETAIL SELALU MUNCUL --}}
<x-filament::button
    size="sm"
    color="info"
    tag="a"
    :href="url('/admin/leave-approval/' . $r->id)">
    Detail
</x-filament::button>

{{-- STAFF --}}
@if($isStaff && $r->user_id == auth()->id())
    @if($r->final_status == 'pending')

        <x-filament::button
            size="sm"
            color="warning"
            wire:click="edit({{ $r->id }})">
            Edit
        </x-filament::button>

        <x-filament::button
            size="sm"
            color="danger"
            wire:click="cancel({{ $r->id }})">
            Cancel
        </x-filament::button>

    @endif
@endif

{{-- DOWNLOAD --}}
@if(
    $r->division_status == 'approved' &&
    $r->hr_status == 'approved' &&
    $r->director_status == 'approved'
)
    <a href="{{ route('leave.pdf',$r->id) }}">
        <x-filament::button size="sm" color="success">
            Download PDF
        </x-filament::button>
    </a>
@endif

</td>

</tr>

{{-- FORM EDIT --}}
@if($editingId == $r->id && $isStaff && $r->user_id == auth()->id())

<tr>
<td colspan="6">
<div class="mt-6 p-6 bg-gray-100 rounded">

<h2 class="font-bold text-lg mb-3">Edit Request</h2>

<div class="mb-3">
<label>Tanggal Mulai</label>
<input type="date" wire:model="start_date" class="border p-2 w-full">
</div>

<div class="mb-3">
<label>Tanggal Selesai</label>
<input type="date" wire:model="end_date" class="border p-2 w-full">
</div>

<div class="mb-3">
<label>Alasan</label>
<textarea wire:model="reason" class="border p-2 w-full"></textarea>
</div>

<x-filament::button color="success" wire:click="update">
    Update
</x-filament::button>

</div>
</td>
</tr>

@endif

@empty

<tr>
<td colspan="6" class="text-center p-5">
Belum ada request cuti
</td>
</tr>

@endforelse

</table>

</x-filament::page>
