@extends('admin.layout.layout')

@section('title', 'Admin - Edit Booking')

@section('content')
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header dan Deskripsi -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold mb-2 text-gray-800">Edit Booking</h1>
            <p class="text-sm text-gray-600">Update status booking konsultasi.</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 text-red-700 border border-red-100 rounded-md">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Edit -->
        <div class="bg-white shadow-sm rounded-md p-6">
            <div class="mb-6 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pasien</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $booking->pasien->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Psikolog</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $booking->psikolog->nama_lengkap }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $booking->jadwal->waktu->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jam</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $booking->jadwal->waktu->format('H:i') }} WIB</p>
                </div>
                <!-- Bukti Pembayaran -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Pembayaran</label>
                    @if($booking->bukti_pembayaran)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $booking->bukti_pembayaran) }}" 
                                 alt="Bukti Pembayaran" 
                                 class="max-w-md rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                            <a href="{{ asset('storage/' . $booking->bukti_pembayaran) }}" 
                               target="_blank"
                               class="mt-2 inline-flex items-center text-sm text-teal-600 hover:text-teal-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat Gambar Lengkap
                            </a>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">Belum ada bukti pembayaran</p>
                    @endif
                </div>
            </div>

            <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Status Booking -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Status Booking</label>
                    <select name="status_akses_layanan"
                        class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm">
                        @foreach(['submitted', 'scheduled', 'completed', 'rescheduled', 'cancel'] as $status)
                            <option value="{{ $status }}" {{ $booking->status === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Submit dan Kembali -->
                <div class="flex items-center space-x-4">
                    <button type="submit"
                        class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 transition">
                        Update Status
                    </button>
                    <a href="{{ route('admin.bookings.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection