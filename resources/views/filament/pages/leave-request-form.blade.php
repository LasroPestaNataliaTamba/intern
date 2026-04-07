<x-filament::page>

@php
    $user = auth()->user();

    // 🔥 ambil semua role & lowercase (anti typo / case sensitive)
    $roles = $user->getRoleNames()->map(fn($r) => strtolower($r));

    // 🔥 fix approver
    $isApprover =
        $roles->contains('kepala divisi') ||
        $roles->contains('HR') ||
        $roles->contains('direktur');
@endphp

<div style="max-width:900px;margin:auto">

    {{-- ================= FORM ================= --}}
    <div style="
        background:white;
        padding:40px;
        border-radius:12px;
        box-shadow:0 4px 20px rgba(0,0,0,0.08);
        margin-bottom:30px;
    ">

        <h2 style="font-size:24px;font-weight:bold;margin-bottom:20px">
            Request Cuti
        </h2>

        <form wire:submit.prevent="submit">

            <div style="display:flex;gap:20px;margin-bottom:20px">

                <div style="flex:1">
                    <label>Rencana Berangkat</label>
                    <input type="date" wire:model="start_date"
                        style="width:100%;margin-top:8px;padding:10px;border-radius:8px;border:1px solid #ddd;">
                </div>

                <div style="flex:1">
                    <label>Rencana Kembali</label>
                    <input type="date" wire:model="end_date"
                        style="width:100%;margin-top:8px;padding:10px;border-radius:8px;border:1px solid #ddd;">
                </div>

            </div>

            <div style="margin-bottom:20px">
                <label>Keperluan Cuti</label>
                <textarea wire:model="reason"
                    style="width:100%;margin-top:8px;padding:10px;border-radius:8px;border:1px solid #ddd;"></textarea>
            </div>

            <button type="submit"
                style="background:#16a34a;color:white;padding:10px 30px;border-radius:8px;">
                Submit
            </button>

        </form>

    </div>

    {{-- ================= HISTORY ================= --}}
    <div style="
        background:white;
        padding:30px;
        border-radius:12px;
        box-shadow:0 4px 20px rgba(0,0,0,0.08);
    ">

        <h3 style="font-size:20px;font-weight:bold;margin-bottom:15px">
            History Request Cuti
        </h3>

        {{-- DEBUG (boleh hapus nanti) --}}
        {{-- {{ json_encode($roles) }} --}}

        <table style="width:100%;border-collapse:collapse">

            <tr style="background:#f3f4f6">
                <th style="padding:10px;border">No</th>

                @if($isApprover)
                    <th style="padding:10px;border">Nama</th>
                @endif

                <th style="padding:10px;border">Tanggal</th>
                <th style="padding:10px;border">Alasan</th>
                <th style="padding:10px;border">Status</th>

                @if($isApprover)
                    <th style="padding:10px;border">Aksi</th>
                @endif
            </tr>

            @forelse($this->requests as $r)

            <tr>
                <td style="padding:10px;border">
                    {{ $loop->iteration }}
                </td>

                @if($isApprover)
                <td style="padding:10px;border">
                    {{ $r->user->name ?? '-' }}
                </td>
                @endif

                <td style="padding:10px;border">
                    {{ $r->start_date }} - {{ $r->end_date }}
                </td>

                <td style="padding:10px;border">
                    {{ $r->reason }}
                </td>

                <td style="padding:10px;border">
                    @if($r->final_status == 'approved')
                        <span style="color:green;font-weight:bold">Approved</span>
                    @elseif($r->final_status == 'rejected')
                        <span style="color:red;font-weight:bold">Rejected</span>
                    @else
                        <span style="color:orange;font-weight:bold">
                            Waiting Approval
                        </span>
                    @endif
                </td>

                {{-- 🔥 BUTTON DETAIL --}}
                {{-- 🔥 BUTTON DETAIL --}}
                @if($isApprover)
                <td style="padding:10px;border">

                    <a href="{{ url('/admin/leave-approval/id' . $r->id) }}"
                    style="
                            background:#3b82f6;
                            color:white;
                            padding:6px 12px;
                            border-radius:6px;
                            text-decoration:none;
                            font-size:12px;
                    ">
                        Lihat Detail
                    </a>

                </td>
                @endif
            </tr>

            @empty

            <tr>
                <td colspan="6" style="text-align:center;padding:15px">
                    Belum ada data
                </td>
            </tr>

            @endforelse

        </table>

    </div>

</div>

</x-filament::page>
