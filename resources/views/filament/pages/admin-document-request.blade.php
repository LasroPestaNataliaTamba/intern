<x-filament::page>

<div class="bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-5">
        Daftar Permintaan Surat
    </h2>

    <table class="w-full border rounded-lg overflow-hidden">

        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 border text-left">User</th>
                <th class="p-3 border text-left">Jenis</th>
                <th class="p-3 border text-left">Keterangan</th>
                <th class="p-3 border text-left">Tanggal</th>
                <th class="p-3 border text-left">Status</th>
                <th class="p-3 border text-left">Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse($this->requests as $r)

            <tr class="hover:bg-gray-50">

                <td class="p-3 border">
                    {{ $r->user->name }}
                </td>

                <td class="p-3 border">
                    {{ ucfirst($r->type) }}
                </td>

                <td class="p-3 border">
                    {{ $r->purpose }}
                </td>

                <td class="p-3 border">
                    {{ $r->needed_date }}
                </td>

                <td class="p-3 border">

                    @if($r->status === 'pending')
                        <span class="text-yellow-600 font-semibold">
                            Menunggu
                        </span>

                    @elseif($r->status === 'approved')
                        <span class="text-green-600 font-semibold">
                            Disetujui
                        </span>

                    @else
                        <span class="text-red-600 font-semibold">
                            Ditolak
                        </span>
                    @endif

                </td>

                <td class="p-3 border">

                    @if($r->status === 'pending')

                        <a href="/admin/process-document-request?record={{ $r->id }}"
                           class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                           Detail
                        </a>

                    @else
                        <span class="text-gray-400">
                            Selesai
                        </span>
                    @endif

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="6" class="text-center p-5 text-gray-500">
                    Belum ada request
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

</x-filament::page>
