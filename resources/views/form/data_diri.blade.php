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
                <input type="text" id="nama" name="nama_lengkap" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl focus:ring-blue-500 focus:border-blue-500 block w-full py-[1rem] px-4" placeholder="nama lengkap" value="{{ $user ? $user->nama_lengkap : '' }}" required />
            </div>
            <div class="relative">
                <label for="program_studi" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">Program studi</label>
                <select id="program_studi" name="program_studi" class="select2 border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl focus:ring-blue-500 focus:border-blue-500 block w-full py-[1rem] px-4 appearance-none bg-[url('{{ asset('images/down-arrow.svg') }}')] bg-no-repeat bg-right-[10px] bg-center">
                    @foreach ($prodi as $prod)
            <option value="{{ $prod->name }}" 
                {{ $user->program_studi == $prod->name ? 'selected' : '' }}>
                {{ $prod->name }}
            </option>
        @endforeach
                </select>
                <img src="{{ asset('images/down-arrow.png') }}" alt="" class="absolute bottom-[1.1rem] right-7 ">
                           
            </div>
            <div>
                <label for="semester" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">semester</label>
                <input type="number" id="company" name="semester"  min="1" max="14" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl  block w-full py-[1rem] px-4 " value="{{ $user ? $user->semester : '' }}" placeholder="contoh : 6" required />
            </div>  
            <div>
                <label class="block mb-5 text-sm font-semibold text-[1rem] text-[#155458]">Jenis Kelamin</label>
                <div class="flex items-center mt-2 text-[#155458]">
                    <label for="laki-laki" class="inline-flex items-center mr-6">
                        <input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki" class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" {{ $user && $user->jenis_kelamin == 'laki-laki' ? 'checked' : '' }}
                        class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]">
                        <span class="ml-2">Laki-laki</span>
                    </label>
                    <label for="perempuan" class="inline-flex items-center">
                        <input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan" class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" {{ $user && $user->jenis_kelamin == 'perempuan' ? 'checked' : '' }}
                        class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]">
                        <span class="ml-2">Perempuan</span>
                    </label>
                </div>
            </div>
            <div>
                <label for="usia" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">Usia</label>
                <input type="number" id="usia" name="usia"  min="0" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl  block w-full py-[1rem] px-4  " value="{{ $user ? $user->usia : '' }}" placeholder="contoh : 20" required />
            </div>
            <div>
                <label for="no_hp" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">No. HP/WA</label>
                <input type="text" id="no_hp" name="no_hp" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl  block w-full py-[1rem] px-4  " value="{{ $user ? $user->no_hp : '' }}" placeholder="contoh : 08****" required />
            </div>
            <div class="relative">
                <label for="departemen" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">Asal departemen</label>
                
                @foreach($departemen as $dep)
                @php
                    $departemenList[] = $dep->name;
                @endphp
                @endforeach
                <select id="departemen" name="departemen" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl focus:ring-blue-500 focus:border-blue-500 block w-full py-[1rem] px-4 appearance-none bg-[url('{{ asset('images/down-arrow.svg') }}')] bg-no-repeat bg-right-[10px] bg-center">
                    @foreach ($departemen as $dep)
                    <option value="{{ $dep->name }}" 
                        {{ $user->departemen == $dep->name ? 'selected' : '' }}>
                        {{ $dep->name }}
                    </option>
                @endforeach
                </select>
                <img src="{{ asset('images/down-arrow.png') }}" alt="" class="absolute bottom-[1.1rem] right-7 ">
                           
            </div>
            <div>
                <label class="block mb-5 text-sm font-semibold text-[1rem] text-[#155458]">Layanan kesehatan mental yang pernah atau sedang diakses</label>
                <div class="flex items-center mt-2 text-[#155458]">
                    <label for="psikolog" class="inline-flex items-center mr-6">
                        <input type="radio" id="psikolog" name="status_akses_layanan" value="psikolog" class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" {{ $user && $user->status_akses_layanan == 'psikolog' ? 'checked' : '' }}>
                        <span class="ml-2">Psikolog</span>
                    </label>
                    <label for="psikiater" class="inline-flex items-center mr-6">
                        <input type="radio" id="psikiater" name="status_akses_layanan" value="psikiater" class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" {{ $user && $user->status_akses_layanan == 'psikiater' ? 'checked' : '' }}>
                        <span class="ml-2">Psikiater</span>
                    </label>
                    <label for="belum" class="inline-flex items-center">
                        <input type="radio" id="belum" name="status_akses_layanan" value="belum pernah" class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" {{ $user && $user->status_akses_layanan == 'belum pernah' ? 'checked' : '' }}>
                        <span class="ml-2">Belum pernah</span>
                    </label>
                </div>
            </div>
        </div>
        
        
        {{-- <div class="flex justify-between mt-20 gap-5">
            <a href="/" class="flex items-center gap-4">
                <img src="{{ asset('images/back.png') }}" alt="Back" class="w-7">
                <span class="text-[1.1rem] text-[#155458] font-bold">Back to home</span>
            </a>                        
            <div>
                <button type="submit" class="font-bold text-white bg-[#155458] px-6 py-3 rounded-md">Update</button>
                <a href="{{ route('google.logout') }}" class="font-bold text-white bg-[#155458] px-6 py-3 rounded-md">Logout</a>
            </div>               
        </div> --}}
            
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