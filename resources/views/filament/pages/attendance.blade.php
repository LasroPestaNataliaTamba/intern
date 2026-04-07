<x-filament::page>

<div class="flex gap-3 mb-6">

<x-filament::button
color="success"
type="button"
onclick="getLocation()">
Check In
</x-filament::button>

<x-filament::button
color="danger"
wire:click="checkOut"
:disabled="!$today || $today->check_out">
Check Out
</x-filament::button>

</div>


{{-- TODAY --}}
@if($today)

<div class="p-4 border rounded mb-6 bg-white shadow-sm">

<h3 class="font-bold text-lg mb-3">
Today Attendance
</h3>

<div class="grid grid-cols-2 gap-4">

<div>
<p class="text-sm text-gray-500">Jam Masuk</p>
<p class="font-semibold">
{{ \Carbon\Carbon::parse($today->check_in)->format('H:i') }}
</p>
</div>

<div>
<p class="text-sm text-gray-500">Jam Keluar</p>
<p class="font-semibold">
{{ $today->check_out
? \Carbon\Carbon::parse($today->check_out)->format('H:i')
: '-' }}
</p>
</div>

</div>

<p class="mt-3">
Status :
@if($today->status == 'late')
<span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs font-semibold">Late</span>
@else
<span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs font-semibold">On Time</span>
@endif
</p>

@if($today->latitude)
<p class="mt-3">
Lokasi :
<a
href="https://www.google.com/maps?q={{ $today->latitude }},{{ $today->longitude }}"
target="_blank"
class="text-blue-600 underline">
Lihat di Maps
</a>
</p>
@endif

</div>

@endif



{{-- 🔥 KHUSUS HR & DIREKTUR --}}
@if(auth()->user()->hasAnyRole(['HR','direktur']))

{{-- ✅ ABSENSI HARI INI --}}
<div class="p-4 border rounded mb-6 bg-white shadow-sm">

<h3 class="font-bold text-lg mb-3">
Absensi Hari Ini (Semua Karyawan)
</h3>

<div class="overflow-x-auto">
<table class="w-full border border-gray-300 text-sm">

<thead class="bg-gray-100 text-gray-700">
<tr>
<th class="p-3 border">Nama</th>
<th class="p-3 border">Jam Masuk</th>
<th class="p-3 border">Jam Keluar</th>
<th class="p-3 border">Status</th>
</tr>
</thead>

<tbody>

@forelse($this->todayAttendances as $att)
<tr class="hover:bg-gray-50">

<td class="p-3 border">{{ $att->user->name }}</td>

<td class="p-3 border">
{{ \Carbon\Carbon::parse($att->check_in)->format('H:i') }}
</td>

<td class="p-3 border">
{{ $att->check_out
? \Carbon\Carbon::parse($att->check_out)->format('H:i')
: '-' }}
</td>

<td class="p-3 border">

@if($att->status == 'late')
<span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs font-semibold">
Late
</span>
@else
<span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs font-semibold">
On Time
</span>
@endif

</td>

</tr>
@empty
<tr>
<td colspan="4" class="text-center p-3">Belum ada absensi</td>
</tr>
@endforelse

</tbody>

</table>
</div>

</div>


{{-- 🔴 BELUM ABSEN --}}
<div class="p-4 border rounded mb-6 bg-white shadow-sm">

<h3 class="font-bold text-lg mb-3 text-red-600">
Belum Absen Hari Ini
</h3>

<div class="grid grid-cols-2 md:grid-cols-3 gap-2">

@forelse($this->notCheckedIn as $user)
<div class="p-2 bg-red-50 border border-red-200 rounded text-sm">
{{ $user->name }}
</div>
@empty
<div class="text-green-600">Semua sudah absen ✅</div>
@endforelse

</div>

</div>


{{-- 🟡 BELUM CHECK OUT --}}
<div class="p-4 border rounded mb-6 bg-white shadow-sm">

<h3 class="font-bold text-lg mb-3 text-yellow-600">
Belum Check Out
</h3>

<table class="w-full border text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-2 border">Nama</th>
<th class="p-2 border">Jam Masuk</th>
</tr>
</thead>

<tbody>

@forelse($this->notCheckedOut as $att)
<tr class="hover:bg-gray-50">
<td class="p-2 border">{{ $att->user->name }}</td>
<td class="p-2 border">
{{ \Carbon\Carbon::parse($att->check_in)->format('H:i') }}
</td>
</tr>
@empty
<tr>
<td colspan="2" class="text-center p-2 text-green-600">
Semua sudah check out ✅
</td>
</tr>
@endforelse

</tbody>

</table>

</div>

@endif



{{-- HISTORY --}}
<div class="p-4 border rounded bg-white shadow-sm">

<h3 class="font-bold text-lg mb-3">
Riwayat Absensi
</h3>

<table class="w-full border text-sm">

<thead class="bg-gray-100">
<tr>

@if(auth()->user()->hasAnyRole(['HR','direktur']))
<th class="p-3 border">Nama</th>
@endif

<th class="p-3 border">Tanggal</th>
<th class="p-3 border">Masuk</th>
<th class="p-3 border">Keluar</th>
<th class="p-3 border">Status</th>

</tr>
</thead>

<tbody>

@foreach($this->history as $h)

<tr class="hover:bg-gray-50">

@if(auth()->user()->hasAnyRole(['HR','direktur']))
<td class="p-3 border">{{ $h->user->name ?? '-' }}</td>
@endif

<td class="p-3 border">
{{ \Carbon\Carbon::parse($h->date)->format('d M Y') }}
</td>

<td class="p-3 border">
{{ \Carbon\Carbon::parse($h->check_in)->format('H:i') }}
</td>

<td class="p-3 border">
{{ $h->check_out
? \Carbon\Carbon::parse($h->check_out)->format('H:i')
: '-' }}
</td>

<td class="p-3 border">

@if($h->status == 'late')
<span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs font-semibold">
Late
</span>
@else
<span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs font-semibold">
On Time
</span>
@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>



<script>
function getLocation(){
navigator.geolocation.getCurrentPosition(
function(position){
window.Livewire.dispatch('checkInLocation',{
lat: position.coords.latitude,
lng: position.coords.longitude
});
},
function(error){
alert('GPS gagal diambil');
}
);
}
</script>

</x-filament::page>
