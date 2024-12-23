@extends('admin.layout.layout')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-2">Admin - Edit Psikolog</h1>
        <p class="text-sm text-slate-500 mb-4">Gunakan form ini untuk memperbarui data psikolog yang telah ada.</p>

        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.psikologs.update', $psikolog) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block mb-1 text-sm text-slate-600">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $psikolog->nama_lengkap) }}"
                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:border-slate-400 shadow-sm" />
            </div>

            <div>
                <label class="block mb-1 text-sm text-slate-600">Email</label>
                <input type="email" name="email" value="{{ old('email', $psikolog->email) }}"
                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:border-slate-400 shadow-sm" />
            </div>

            <div>
                <label class="block mb-1 text-sm text-slate-600">Password (kosongkan jika tidak diubah)</label>
                <input type="password" name="password"
                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:border-slate-400 shadow-sm" />
            </div>

            <div>
                <label class="block mb-1 text-sm text-slate-600">Confirm Password (kosongkan jika tidak diubah)</label>
                <input type="password" name="confirmPassword"
                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:border-slate-400 shadow-sm" />
            </div>

            <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded hover:bg-teal-600">Update</button>
            <a href="{{ route('admin.psikologs.index') }}"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Kembali</a>
        </form>
    </div>
@endsection
