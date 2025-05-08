@extends('admin.layout.layout')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header and Description -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold mb-2 text-gray-800">Edit Pengguna</h1>
                <p class="text-sm text-gray-600">Perbarui informasi untuk {{ $user->name }}</p>
            </div>
            <div>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow-sm rounded-md overflow-hidden p-6">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Informasi Dasar</h2>
                        
                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                    class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                    class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Password <span class="text-xs text-gray-500">(kosongkan untuk mempertahankan password saat ini)</span>
                                </label>
                                <input type="password" name="password" id="password" 
                                    class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Peran</label>
                                <select name="role" id="role" 
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                                    <option value="user" {{ (old('role', $user->role) == 'user') ? 'selected' : '' }}>Pengguna</option>
                                    <option value="psikolog" {{ (old('role', $user->role) == 'psikolog') ? 'selected' : '' }}>Psikolog</option>
                                    <option value="admin" {{ (old('role', $user->role) == 'admin') ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information (optional, if needed) -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Informasi Profil</h2>
                        
                        <div class="space-y-4">
                            <!-- Full Name -->
                            <div>
                                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" 
                                    class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            
                            <!-- Age -->
                            <div>
                                <label for="usia" class="block text-sm font-medium text-gray-700">Usia</label>
                                <input type="number" name="usia" id="usia" value="{{ old('usia', $user->usia) }}" 
                                    class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" 
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ (old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ (old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $user->no_hp) }}" 
                                    class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 border-t pt-5">
                    <div class="flex justify-end">
                        <button type="button" onclick="window.history.back()" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 mr-3">
                            Batal
                        </button>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            Perbarui Pengguna
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection 