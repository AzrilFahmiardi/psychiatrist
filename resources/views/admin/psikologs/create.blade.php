@extends('admin.layout.layout')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-2">Admin - Tambah Psikolog</h1>
        <p class="text-sm text-slate-500 mb-4">Gunakan form ini untuk menambahkan psikolog baru ke dalam sistem.</p>

        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.psikologs.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block mb-1 text-sm text-slate-600">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:border-slate-400 shadow-sm"
                    placeholder="Nama Lengkap" />
            </div>

            <div>
                <label class="block mb-1 text-sm text-slate-600">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:border-slate-400 shadow-sm"
                    placeholder="Email" />
            </div>

            <div>
                <label class="block mb-1 text-sm text-slate-600">Password</label>
                <input type="password" name="password"
                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:border-slate-400 shadow-sm"
                    placeholder="Password" />
            </div>

            <button data-ripple-light="true" type="submit"
                class="mb-5 inline-block lign-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 px-6 rounded-lg bg-gray-900 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none">Simpan</button>
            <a href="{{ route('admin.psikologs.index') }}"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Kembali</a>
        </form>
    </div>
@endsection
