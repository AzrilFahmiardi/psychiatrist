@extends('admin.layout.layout')

@section('content')
    <div class="p-6 ">
        <h1 class="text-2xl font-bold mb-2">Admin - Psikologs</h1>

        @if (session('success'))
            <div role="alert" class="mb-5 relative flex w-full p-3 text-sm text-white bg-green-500 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        {{-- Contoh Tabel --}}
        <div class="w-full">
            <h3 class="text-lg font-semibold ml-3 text-slate-800">Daftar Psikolog</h3>
            <p class="text-slate-500 ml-3">Informasi mengenai para psikolog yang terdaftar beserta email dan perannya.
            </p>
        </div>

        <div class="w-full flex justify-end">
            <a href="{{ route('admin.psikologs.create') }}" data-ripple-light="true"
                class=" mb-5 inline-block lign-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 px-6 rounded-lg bg-gray-900 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none">
                Tambah Psikolog
            </a>
        </div>

        <div
            class="relative flex flex-col w-full h-full overflow-auto z-0 text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
            <table class="w-full z-0 text-left table-auto min-w-max">
                <thead>
                    <tr>
                        <th class="p-4 border-b border-slate-300 bg-slate-50">Nama Lengkap</th>
                        <th class="p-4 border-b border-slate-300 bg-slate-50">Role</th>
                        <th class="p-4 border-b border-slate-300 bg-slate-50">Email</th>
                        <th class="p-4 border-b border-slate-300 bg-slate-50">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($psikologs as $psikolog)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 border-b border-slate-200">{{ $psikolog->nama_lengkap }}</td>
                            <td class="p-4 border-b border-slate-200 capitalize">{{ $psikolog->role }}</td>
                            <td class="p-4 border-b border-slate-200">{{ $psikolog->email }}</td>
                            <td class="p-4 border-b border-slate-200">
                                <a href="{{ route('admin.psikologs.edit', $psikolog) }}"
                                    class="text-blue-500 hover:underline mr-2">Edit</a>
                                <form action="{{ route('admin.psikologs.destroy', $psikolog) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Hapus psikolog ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 border-b border-slate-200 text-center text-slate-500">Tidak ada
                                data psikolog.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
