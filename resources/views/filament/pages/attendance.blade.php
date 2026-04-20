<x-filament::page>

<div class="mx-auto max-w-6xl space-y-6">
    {{-- Action Buttons --}}
    <div class="flex flex-col sm:flex-row gap-3">
        <x-filament::button
            color="success"
            type="button"
            icon="heroicon-o-map-pin"
            size="lg"
            onclick="getLocation()">
            Check In
        </x-filament::button>

        <x-filament::button
            color="danger"
            wire:click="checkOut"
            icon="heroicon-o-arrow-right-on-rectangle"
            size="lg"
            :disabled="!$today || $today->check_out">
            Check Out
        </x-filament::button>
    </div>

    {{-- TODAY --}}
    @if($today)
    <x-filament::section
        class="!h-auto"
        title="Today's Attendance"
        description="Your attendance status for today"
        icon="heroicon-o-calendar"
        collapsible
        collapsed="false">

    <div class="overflow-x-auto">
    <table class="w-full border border-gray-300 border-separate border-spacing-4 text-sm">

            {{-- Header --}}
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-6 py-3 text-center">Check In</th>
                    <th class="border px-6 py-3 text-center">Check Out</th>
                    <th class="border px-6 py-3 text-center">Status</th>
                </tr>
            </thead>

            {{-- Isi --}}
            <tbody>
                <tr class="text-center">

                    <td class="border px-6 py-4">
                        🔒 {{ \Carbon\Carbon::parse($today->check_in)->format('H:i') }}
                    </td>

                    <td class="border px-6 py-4">
                        🔓 {{ $today->check_out ? \Carbon\Carbon::parse($today->check_out)->format('H:i') : '—' }}
                    </td>

                    <td class="border px-6 py-4">
                        @if($today->status == 'late')
                            <span class="text-red-500 font-semibold">⚠️ Late</span>
                        @else
                            <span class="text-green-600 font-semibold">✅ On Time</span>
                        @endif
                    </td>

                </tr>
            </tbody>

        </table>
    </div>
    </x-filament::section>
    @endif

    @if(auth()->user()->hasAnyRole(['HR','direktur']))
    {{-- TODAY ATTENDANCES FOR HR/DIREKTUR --}}
    <x-filament::section
        class="!h-auto"
        title="Today's Employee Attendance"
        description="All employees who have checked in today"
        icon="heroicon-o-users"
        collapsible
        collapsed="false">

        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="border-b-2 border-gray-300 bg-gray-50">
                        <th class="px-6 py-2 text-left text-gray-600 font-medium">Name</th>
                        <th class="px-6 py-2 text-left text-gray-600 font-medium">Check In</th>
                        <th class="px-6 py-2 text-left text-gray-600 font-medium">Check Out</th>
                        <th class="px-6 py-2 text-left text-gray-600 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->todayAttendances as $att)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-2 text-gray-700">{{ $att->user->name }}</td>
                        <td class="px-6 py-2 text-gray-700">{{ \Carbon\Carbon::parse($att->check_in)->format('H:i') }}</td>
                        <td class="px-6 py-2 text-gray-700">{{ $att->check_out ? \Carbon\Carbon::parse($att->check_out)->format('H:i') : '—' }}</td>
                        <td class="px-6 py-2 text-gray-700">{{ $att->status === 'late' ? 'Late' : 'On Time' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-400">No attendance today</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </x-filament::section>

    <x-filament::section
        class="!h-auto"
        title="Not Checked In Today"
        description="Employees who have not checked in yet"
        icon="heroicon-o-clock"
        collapsible
        collapsed="false">

        @if($this->notCheckedIn->isEmpty())
            <div class="text-center py-6 text-gray-500">All employees have checked in today.</div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($this->notCheckedIn as $user)
                <div class="p-3 bg-red-50 border-l-4 border-red-400 rounded-r-lg text-sm text-red-700">
                    {{ $user->name }}
                </div>
                @endforeach
            </div>
        @endif

    </x-filament::section>

    <x-filament::section
        class="!h-auto"
        title="Not Checked Out"
        description="Employees who still need to check out"
        icon="heroicon-o-arrow-left-on-rectangle"
        collapsible
        collapsed="false">

        @if($this->notCheckedOut->isEmpty())
            <div class="text-center py-6 text-gray-500">Everyone has checked out.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="border-b-2 border-gray-300 bg-gray-50">
                            <th class="px-6 py-2 text-left text-gray-600 font-medium">Name</th>
                            <th class="px-6 py-2 text-left text-gray-600 font-medium">Check In</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->notCheckedOut as $att)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-2 text-gray-700">{{ $att->user->name }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ \Carbon\Carbon::parse($att->check_in)->format('H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </x-filament::section>
    @endif

    {{-- HISTORY --}}
    <x-filament::section
        class="!h-auto"
        title="Attendance History"
        description="Your attendance records"
        icon="heroicon-o-document-chart-bar"
        collapsible
        collapsed="false">

        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="border-b-2 border-gray-300 bg-gray-50">
                        @if(auth()->user()->hasAnyRole(['HR','direktur']))
                        <th class="px-6 py-2 text-left text-gray-600 font-medium">Name</th>
                        @endif
                        <th class="px-6 py-2 text-left text-gray-600 font-medium">Date</th>
                        <th class="px-6 py-2 text-left text-gray-600 font-medium">Check In</th>
                        <th class="px-6 py-2 text-left text-gray-600 font-medium">Check Out</th>
                        <th class="px-6 py-2 text-left text-gray-600 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->history as $h)
                    <tr class="border-b hover:bg-gray-50">
                        @if(auth()->user()->hasAnyRole(['HR','direktur']))
                        <td class="px-6 py-2 text-gray-700">{{ $h->user->name ?? '—' }}</td>
                        @endif
                        <td class="px-6 py-2 text-gray-700">{{ $h->date }}</td>
                        <td class="px-6 py-2 text-gray-700">{{ $h->check_in }}</td>
                        <td class="px-6 py-2 text-gray-700">{{ $h->check_out ?? '—' }}</td>
                        <td class="px-6 py-2 text-gray-700">{{ $h->status }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->hasAnyRole(['HR','direktur']) ? 5 : 4 }}" class="text-center py-4 text-gray-400">No history</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </x-filament::section>

<script>
function getLocation(){
    navigator.geolocation.getCurrentPosition(
        function(position){
            window.Livewire.dispatch('checkInLocation', {
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

</div>

</x-filament::page>
