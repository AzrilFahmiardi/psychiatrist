@extends('admin.layout.layout')

@section('title', 'Admin - Jadwal Psikolog')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header dan Deskripsi -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold mb-2 text-gray-800">Admin - Jadwal Psikolog</h1>
            <p class="text-sm text-gray-600">Kelola jadwal psikolog di sini. Anda dapat menambah, melihat, dan menghapus
                jadwal sesuai kebutuhan.</p>
        </div>

        <div class="w-full flex justify-end">
            <a href="{{ route('admin.jadwals.create') }}" data-ripple-light="true"
                class=" mb-5 inline-block align-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 px-6 rounded-lg bg-gray-900 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none">
                Tambah Jadwal
            </a>
        </div>

        <!-- Filter dan Navigasi Minggu -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
            <!-- Filter Psikolog -->
            <div class="w-full max-w-sm min-w-[200px]">
                <div class="relative">
                    <select name="psikolog_id" id="filter-psikolog"
                        class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer">
                        <option value="">-- Semua Psikolog --</option>
                        @foreach ($psikologs as $psikolog)
                            <option value="{{ $psikolog->id }}" {{ $psikolog_id == $psikolog->id ? 'selected' : '' }}>
                                {{ $psikolog->nama_lengkap }} ({{ $psikolog->email }})
                            </option>
                        @endforeach
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2"
                        stroke="currentColor" class="h-5 w-5 ml-1 absolute top-2.5 right-2.5 text-slate-700">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                    </svg>
                </div>
            </div>

            <!-- Navigasi Minggu -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.jadwals.index', ['week' => $startOfWeek->copy()->subWeek()->format('Y-m-d'), 'psikolog_id' => $psikolog_id]) }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Minggu Lalu</a>
                <span class="text-lg font-semibold text-gray-800">{{ $startOfWeek->copy()->format('d M Y') }} -
                    {{ $endOfWeek->copy()->format('d M Y') }}</span>
                <a href="{{ route('admin.jadwals.index', ['week' => $startOfWeek->copy()->addWeek()->format('Y-m-d'), 'psikolog_id' => $psikolog_id]) }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Minggu Depan</a>
            </div>
        </div>

        <!-- Kalender Mingguan -->
        <div class="overflow-auto">
            <div class="grid grid-cols-6 bg-gray-100 text-gray-600">
                <!-- Time Column -->
                <div class="p-4 border-r border-gray-200">
                    <p class="text-sm font-medium">Jam</p>
                </div>
                <!-- Hari Senin - Jumat -->
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                    <div class="p-4 border-r border-gray-200">
                        <p class="text-sm font-medium">{{ $day }}</p>
                    </div>
                @endforeach
            </div>
            @php
                // Definisikan jam kerja (08:00 - 18:00)
                $startHour = 8;
                $endHour = 18;
                $hours = [];
                for ($hour = $startHour; $hour <= $endHour; $hour++) {
                    $time = Carbon\Carbon::createFromTime($hour, 0)->format('H:i');
                    $hours[] = $time;
                }
            @endphp
            @foreach ($hours as $time)
                <div class="grid grid-cols-6 border-b border-gray-200">
                    <!-- Jam -->
                    <div class="p-4 border-r border-gray-200">
                        <p class="text-sm text-gray-700">{{ $time }}</p>
                    </div>
                    <!-- Hari Senin - Jumat -->
                    @for ($i = 0; $i < 5; $i++)
                        @php
                            $currentDay = $startOfWeek->copy()->addDays($i)->toDateString();
                            $jadwalsSaatIni = $jadwalGrouped[$currentDay][$time] ?? [];
                        @endphp
                        <div class="p-4 border-r border-gray-200 relative">
                            @if (count($jadwalsSaatIni) > 0)
                            @foreach ($jadwalsSaatIni as $jadwal)
                                <div class="mb-2">
                                    <div class="bg-teal-100 text-teal-800 rounded px-2 py-1 text-sm flex justify-between items-center">
                                        <div class="flex flex-col">
                                            <span>{{ $jadwal->psikolog->nama_lengkap }}</span>
                                            
                                            
                                            @if($jadwal->bookings->count() > 0)
                                                @php
                                                    $statusClass = match($jadwal->bookings[0]->status) {
                                                        'submitted' => 'bg-yellow-100 text-yellow-800',
                                                        'scheduled' => 'bg-blue-100 text-blue-800',
                                                        'completed' => 'bg-green-100 text-green-800',
                                                        'rescheduled' => 'bg-orange-100 text-orange-800',
                                                        'cancel' => 'bg-red-100 text-red-800',
                                                        default => 'bg-gray-100 text-gray-800'
                                                    };
                                                @endphp
                                                <a href="{{ route('admin.bookings.edit', $jadwal->bookings[0]) }}" class="text-xs font-semibold mt-1 px-2 py-0.5 rounded-sm {{ $statusClass }}">
                                                    {{ ucfirst($jadwal->bookings[0]->status) }}
                                                </a>
                                            @endif
                                        </div>
                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.jadwals.destroy', $jadwal) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="if(confirm('Hapus jadwal ini?')) { this.parentElement.submit(); }"
                                                class="text-red-600 hover:text-red-800 focus:outline-none">
                                                <i class="fa fa-trash ms-1"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-gray-400 text-sm">-</div>
                        @endif
                        </div>
                    @endfor
                </div>
            @endforeach
        </div>
    </div>

    <!-- Script untuk Filter dan Navigasi -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterPsikolog = document.getElementById('filter-psikolog');
            filterPsikolog.addEventListener('change', function() {
                const psikologId = this.value;
                const urlParams = new URLSearchParams(window.location.search);
                if (psikologId) {
                    urlParams.set('psikolog_id', psikologId);
                } else {
                    urlParams.delete('psikolog_id');
                }
                window.location.search = urlParams.toString();
            });
        });
    </script>
@endsection
