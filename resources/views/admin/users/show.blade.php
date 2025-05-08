@extends('admin.layout.layout')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header and Description -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold mb-2 text-gray-800">Detail Pengguna</h1>
                <p class="text-sm text-gray-600">Melihat informasi pengguna untuk {{ $user->name }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
                {{-- <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a> --}}
            </div>
        </div>

        <!-- User Information Card -->
        <div class="bg-white shadow-sm rounded-md overflow-hidden p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Informasi Dasar</h2>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Nama:</span>
                            <p class="mt-1">{{ $user->name }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm font-medium text-gray-500">Email:</span>
                            <p class="mt-1">{{ $user->email }}</p>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-gray-500">Peran:</span>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $user->role === 'psikolog' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $user->role === 'user' ? 'bg-green-100 text-green-800' : '' }}">
                                    {{ $user->role === 'admin' ? 'Admin' : '' }}
                                    {{ $user->role === 'psikolog' ? 'Psikolog' : '' }}
                                    {{ $user->role === 'user' ? 'Pengguna' : '' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-gray-500">Google ID:</span>
                            <p class="mt-1">{{ $user->google_id ?? 'Tidak Ada' }}</p>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-gray-500">Dibuat:</span>
                            <p class="mt-1">{{ $user->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Informasi Profil</h2>
                    
                    <div class="space-y-3">
                        @if($user->nama_lengkap)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Nama Lengkap:</span>
                            <p class="mt-1">{{ $user->nama_lengkap }}</p>
                        </div>
                        @endif

                        @if($user->usia)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Usia:</span>
                            <p class="mt-1">{{ $user->usia }}</p>
                        </div>
                        @endif

                        @if($user->jenis_kelamin)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Jenis Kelamin:</span>
                            <p class="mt-1">{{ $user->jenis_kelamin }}</p>
                        </div>
                        @endif

                        @if($user->no_hp)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Nomor Telepon:</span>
                            <p class="mt-1">{{ $user->no_hp }}</p>
                        </div>
                        @endif

                        @if($user->departemen)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Departemen:</span>
                            <p class="mt-1">
                                @if(is_numeric($user->departemen) && $user->getDepartemen)
                                    {{ $user->getDepartemen->name }}
                                @else
                                    {{ $user->departemen }}
                                @endif
                            </p>
                        </div>
                        @endif

                        @if($user->program_studi)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Program Studi:</span>
                            <p class="mt-1">
                                @if(is_numeric($user->program_studi) && $user->programStudi)
                                    {{ $user->programStudi->name }}
                                @else
                                    {{ $user->program_studi }}
                                @endif
                            </p>
                        </div>
                        @endif

                        @if($user->semester)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Semester:</span>
                            <p class="mt-1">{{ $user->semester }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking History Section (if needed) -->
        <div class="mt-8 bg-white shadow-sm rounded-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Riwayat Booking</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Psikolog</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($user->bookings ?? [] as $booking)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $booking->jadwal->waktu->format('d M Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $booking->jadwal->waktu->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->psikolog->nama_lengkap }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $booking->status === 'scheduled' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $booking->status === 'submitted' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $booking->status === 'rescheduled' ? 'bg-orange-100 text-orange-800' : '' }}
                                        {{ $booking->status === 'cancel' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ $booking->status === 'completed' ? 'Selesai' : '' }}
                                        {{ $booking->status === 'scheduled' ? 'Terjadwal' : '' }}
                                        {{ $booking->status === 'submitted' ? 'Diajukan' : '' }}
                                        {{ $booking->status === 'rescheduled' ? 'Dijadwalkan Ulang' : '' }}
                                        {{ $booking->status === 'cancel' ? 'Dibatalkan' : '' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ route('admin.bookings.edit', $booking) }}" 
                                       class="text-teal-600 hover:text-teal-900">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada riwayat booking yang ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection 