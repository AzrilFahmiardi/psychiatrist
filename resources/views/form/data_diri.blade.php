@extends('form_layout')

@section('konten')

{{-- PROGRESS BAR --}}
<div class="w-[70%] item mx-auto my-6 flex items-center gap-x-5">
    <div class="w-full flex flex-col gap-3">
        <label>Persetujuan</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full flex flex-col gap-3">
        <label>Data diri</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 " role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full flex flex-col gap-3">
        <label>Pilih jadwal</label>

        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-[#CDCDCD]" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full flex flex-col gap-3">
        <label>Ketentuan & submit</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-[#CDCDCD]" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full flex flex-col gap-3">
        <label>Pembayaran</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-[#CDCDCD]" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>

{{-- KONTEN FORM --}}
<div class="w-full px-[10rem]">
    <h1 class="text-center text-[#155458] text-xl font-bold my-10">Validasi data pribadi</h1>
    @php
        $departemenList = [];
        $programStudiList = [];
    @endphp
    <form action="{{ route('pasien.update')}}" method="post">
        @csrf
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="nama" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">Nama pendaftar</label>
                <input type="text" id="nama" name="nama_lengkap" 
                    class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl block w-full py-[1rem] px-4" 
                    value="{{ $user ? $user->nama_lengkap : '' }}" 
                    readonly disabled />
            </div>
            <div class="relative">
                <label for="program_studi" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">Program studi</label>
                <select id="program_studi" name="program_studi" 
                    class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl block w-full py-[1rem] px-4 appearance-none"
                    disabled>
                    @foreach ($prodi as $prod)
                        <option value="{{ $prod->name }}" 
                            {{ $user->program_studi == $prod->name ? 'selected' : '' }}>
                            {{ $prod->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="semester" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">semester</label>
                <input type="number" id="company" name="semester" 
                    class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl block w-full py-[1rem] px-4" 
                    value="{{ $user ? $user->semester : '' }}" 
                    readonly disabled />
            </div>  
            <div>
                <label class="block mb-5 text-sm font-semibold text-[1rem] text-[#155458]">Jenis Kelamin</label>
                <div class="flex items-center mt-2 text-[#155458]">
                    <label for="laki-laki" class="inline-flex items-center mr-6">
                        <input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki" 
                        {{ $user && $user->jenis_kelamin == 'laki-laki' ? 'checked' : '' }}
                        disabled>
                        <span class="ml-2">Laki-laki</span>
                    </label>
                    <label for="perempuan" class="inline-flex items-center">
                        <input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan" 
                        {{ $user && $user->jenis_kelamin == 'perempuan' ? 'checked' : '' }}
                        disabled>
                        <span class="ml-2">Perempuan</span>
                    </label>
                </div>
            </div>
            <div>
                <label for="usia" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">Usia</label>
                <input type="number" id="usia" name="usia" 
                    class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl block w-full py-[1rem] px-4" 
                    value="{{ $user ? $user->usia : '' }}" 
                    readonly disabled />
            </div>
            <div>
                <label for="no_hp" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">No. HP/WA</label>
                <input type="text" id="no_hp" name="no_hp" 
                    class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl block w-full py-[1rem] px-4" 
                    value="{{ $user ? $user->no_hp : '' }}" 
                    readonly disabled />
            </div>
            <div class="relative">
                <label for="departemen" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">Asal departemen</label>
                <select id="departemen" name="departemen" 
                    class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl block w-full py-[1rem] px-4 appearance-none"
                    disabled>
                    @foreach ($departemen as $dep)
                        <option value="{{ $dep->name }}" 
                            {{ $user->departemen == $dep->name ? 'selected' : '' }}>
                            {{ $dep->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-5 text-sm font-semibold text-[1rem] text-[#155458]">Layanan kesehatan mental yang pernah atau sedang diakses</label>
                <div class="flex items-center mt-2 text-[#155458]">
                    <label for="psikolog" class="inline-flex items-center mr-6">
                        <input type="radio" id="psikolog" name="status_akses_layanan" value="psikolog" 
                        {{ $user && $user->status_akses_layanan == 'psikolog' ? 'checked' : '' }}
                        disabled>
                        <span class="ml-2">Psikolog</span>
                    </label>
                    <label for="psikiater" class="inline-flex items-center mr-6">
                        <input type="radio" id="psikiater" name="status_akses_layanan" value="psikiater" 
                        {{ $user && $user->status_akses_layanan == 'psikiater' ? 'checked' : '' }}
                        disabled>
                        <span class="ml-2">Psikiater</span>
                    </label>
                    <label for="belum" class="inline-flex items-center">
                        <input type="radio" id="belum" name="status_akses_layanan" value="belum pernah" 
                        {{ $user && $user->status_akses_layanan == 'belum pernah' ? 'checked' : '' }}
                        disabled>
                        <span class="ml-2">Belum pernah</span>
                    </label>
                </div>
            </div>
        </div>
        
    </form>
</div>

{{-- TOMBOL --}}
<div class="absolute w-full flex justify-between px-10 bottom-16">
    <div class="flex h-[1.5rem] items-center gap-4">
        <a href="{{ route('form.persetujuan') }}" class="flex items-center gap-4">
            <img src="{{ asset('images/back.png') }}" alt="Back">
            <span class="text-[1.5rem] text-[#155458] font-bold">Back</span>
        </a>
    </div>
    <div class="flex h-[1.5rem] items-center gap-4">
        <a id="next-button" href="{{ route('form.pilih_jadwal') }}" class="flex items-center gap-4">
            <span class="text-[1.5rem] text-[#155458] font-bold">Next</span>
            <img src="{{ asset('images/next.png') }}" alt="Next">
        </a>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>



@endsection