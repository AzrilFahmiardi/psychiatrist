@extends('admin.layout.layout')

@section('title', 'Admin - Manajemen Pengguna')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header and Description -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold mb-2 text-gray-800">Manajemen Pengguna</h1>
            <p class="text-sm text-gray-600">Kelola pengguna dan peran mereka dalam sistem.</p>
        </div>

        <!-- Action Buttons -->
        {{-- <div class="mb-6 flex justify-end">
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 transition flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Pengguna Baru
            </a>
        </div> --}}

        <!-- Users List -->
        <div class="bg-white shadow-sm rounded-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->name }}</div>
                                @if($user->nama_lengkap)
                                    <div class="text-xs text-gray-500">{{ $user->nama_lengkap }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $user->role === 'psikolog' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $user->role === 'user' ? 'bg-green-100 text-green-800' : '' }}">
                                    {{ $user->role === 'admin' ? 'Admin' : '' }}
                                    {{ $user->role === 'psikolog' ? 'Psikolog' : '' }}
                                    {{ $user->role === 'user' ? 'Pengguna' : '' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-teal-600 hover:text-teal-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada pengguna yang ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection 