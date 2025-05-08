@extends('admin.layout.layout')

@section('title', 'Admin - List Booking')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header dan Deskripsi -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold mb-2 text-gray-800">Admin - List Booking</h1>
            <p class="text-sm text-gray-600">Kelola dan pantau status booking konsultasi.</p>
        </div>

        <!-- Filter Section -->
        <div class="bg-white shadow-sm rounded-md p-6 mb-6">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:space-x-4">
                <!-- Filter Psikolog -->
                <div class="flex-1">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Filter Psikolog</label>
                    <select name="psikolog_id" 
                            class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm">
                        <option value="">Semua Psikolog</option>
                        @foreach ($psikologs as $psikolog)
                            <option value="{{ $psikolog->id }}" {{ $selectedPsikolog == $psikolog->id ? 'selected' : '' }}>
                                {{ $psikolog->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Status -->
                <div class="flex-1">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Status Booking</label>
                    <select name="status" 
                            class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm">
                        @foreach(['submitted', 'scheduled', 'completed', 'rescheduled', 'cancel'] as $status)
                            <option value="{{ $status }}" {{ $selectedStatus == $status ? 'selected' : '' }}>
                                @if($status == 'submitted')
                                    Diajukan
                                @elseif($status == 'scheduled')
                                    Terjadwal
                                @elseif($status == 'completed')
                                    Selesai
                                @elseif($status == 'rescheduled')
                                    Dijadwalkan Ulang
                                @elseif($status == 'cancel')
                                    Dibatalkan
                                @else
                                    {{ ucfirst($status) }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full md:w-auto px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 transition">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Booking List -->
        <div class="bg-white shadow-sm rounded-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Psikolog</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <a href="{{ route('admin.users.show', $booking->pasien->id) }}" class="text-teal-600 hover:text-teal-900">
                                        {{ $booking->pasien->name }}
                                    </a>
                                </div>
                                <div class="text-sm text-gray-500">{{ $booking->pasien->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $booking->psikolog->nama_lengkap }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $booking->jadwal->waktu->format('d M Y') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $booking->jadwal->waktu->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $booking->status === 'scheduled' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $booking->status === 'submitted' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $booking->status === 'rescheduled' ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $booking->status === 'cancel' ? 'bg-red-100 text-red-800' : '' }}">
                                    @if($booking->status == 'completed')
                                        Selesai
                                    @elseif($booking->status == 'scheduled')
                                        Terjadwal
                                    @elseif($booking->status == 'submitted')
                                        Diajukan
                                    @elseif($booking->status == 'rescheduled')
                                        Dijadwalkan Ulang
                                    @elseif($booking->status == 'cancel')
                                        Dibatalkan
                                    @else
                                        {{ ucfirst($booking->status) }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="{{ route('admin.bookings.edit', $booking) }}" 
                                   class="text-teal-600 hover:text-teal-900">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada booking yang ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $bookings->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection