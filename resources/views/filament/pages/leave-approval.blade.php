<x-filament::page>

<div>

<table class="w-full border rounded-lg overflow-hidden">

<tr class="bg-gray-100 text-left">
    <th class="p-3 border">Nama</th>
    <th class="p-3 border">Tanggal</th>
    <th class="p-3 border">Alasan</th>
    <th class="p-3 border">Status</th>
    <th class="p-3 border">Aksi</th>
</tr>

@foreach($this->requests as $leave)

<tr class="border-b">

<td class="p-3 border">{{ $leave->user->name }}</td>

<td class="p-3 border">
{{ $leave->start_date }} - {{ $leave->end_date }}
</td>

<td class="p-3 border">{{ $leave->reason }}</td>

<td class="p-3 border">
{{ ucfirst($leave->final_status) }}
</td>

<td class="p-3 border">

<x-filament::button
color="info"
wire:click="select({{ $leave->id }})">
Detail
</x-filament::button>

</td>

</tr>

@endforeach

</table>

@if($selected)

<div class="mt-8 p-6 bg-gray-50 rounded-lg">

<h2 class="text-lg font-bold mb-3">Detail Request</h2>

<p><b>Nama:</b> {{ $selected->user->name }}</p>
<p><b>Alasan:</b> {{ $selected->reason }}</p>
<p><b>Tanggal:</b> {{ $selected->start_date }} - {{ $selected->end_date }}</p>

<p class="mt-3">Division: {{ $selected->division_status }}</p>
<p>HR: {{ $selected->hr_status }}</p>
<p>Direktur: {{ $selected->director_status }}</p>
<p>Final: {{ $selected->final_status }}</p>

<div class="mt-4">

<b>Status Flow:</b><br>

@if($selected->final_status == 'approved')
    <span class="text-green-600">Approved</span>

@elseif($selected->final_status == 'rejected')
    <span class="text-red-600">Rejected</span>

@elseif($selected->director_status == 'pending')
    Waiting Direktur

@elseif($selected->hr_status == 'pending')
    Waiting HR

@elseif($selected->division_status == 'pending')
    Waiting Division Head

@else
    Processing
@endif

</div>

<div class="flex gap-3 mt-5">

<x-filament::button color="success" wire:click="approve">
Approve
</x-filament::button>

<x-filament::button color="danger" wire:click="reject">
Reject
</x-filament::button>

</div>

</div>

@endif

</div>

</x-filament::page>
