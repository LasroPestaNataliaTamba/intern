<x-filament::page>

<table class="w-full border">

<tr>
<th>Barang</th>
<th>Qty</th>
<th>Harga</th>
<th>Total</th>
<th>No Rek</th>
<th>Bukti</th>
<th>Aksi</th>
</tr>

@foreach($this->repurchases as $r)

<tr>

<td>{{ $r->item_name }}</td>
<td>{{ $r->qty }}</td>
<td>{{ $r->price }}</td>
<td>{{ $r->total }}</td>

<td><strong>{{ $r->bank_account }}</strong></td>

<td>
<a href="{{ asset('storage/'.$r->proof_pdf) }}" target="_blank">
PDF
</a>
</td>

<td>

<button wire:click="approve({{ $r->id }})">
Approve
</button>

<button wire:click="reject({{ $r->id }})">
Reject
</button>

</td>

</tr>

@endforeach

</table>

</x-filament::page>
