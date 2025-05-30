@extends('form_layout')

@section('konten')

{{-- PROGRESS BAR --}}
<div class="w-[70%] item mx-auto my-6  md:flex gap-x-5 ">
    <div class="w-full md:w-[16em] flex flex-col gap-3 justify-between ">
        <label class="text-xs md:text-xs lg:text-base">Persetujuan</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full md:w-[16em] flex flex-col gap-3 justify-between">
        <label class="text-xs md:text-xs lg:text-base">Data diri</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 " role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full md:w-[16em] flex flex-col gap-3 justify-between">
        <label class="text-xs md:text-xs lg:text-base">Pilih jadwal</label>

        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full md:w-[16em] flex flex-col gap-3 justify-between">
        <label class="text-xs md:text-xs lg:text-base">Ketentuan & submit</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full md:w-[16em] flex flex-col gap-3 justify-between">
        <label class="text-xs md:text-xs lg:text-base">Pembayaran</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-[#CDCDCD]" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>

{{-- KONTEN FORM --}}
<div class="w-full">
    <h1 class="text-center text-[#155458] text-xs sm:text-md md:text-xl font-bold my-10">Ketentuan saat melakukan konseling</h1>
    <div class="flex flex-col gap-5">
        <div class="w-2/3 mx-auto border border-[#4F4F4F] rounded-2xl p-5">
            <p class="mb-5 text-xs sm:text-sm md:text-base font-semibold">Dimohon untuk berkomitmen hadir sesuai dengan jadwal yang telah dipilih karena keterbatasan kuota untuk memfasilitasi mahasiswa yang lain. Harap datang tepat waktu sesuai jadwal yang dipilih dan mohon untuk membawa identitas diri (KTP/SIM/sejenisnya) saat konseling. </p>
            <input id="persetujuan-1" type="checkbox">
            <label for="persetujuan-1" class="text-[#155458] font-semibold  text-xs sm:text-sm md:text-base">Saya mengerti</label>
        </div>

    </div>
    

</div>
{{-- TOMBOL --}}
<div class="absolute w-full flex justify-between px-10 bottom-16">
    <div class="flex h-[1.5rem] items-center gap-4">
        <a href="{{ route('form.pilih_jadwal') }}" class="flex items-center gap-4">
            <img src="{{ asset('images/back.png') }}" alt="Back" class="h-[0.8rem] sm:h-[1.2rem] md:h-[1.5rem] w-auto">
            <span class="text-[0.8rem] sm:text-[1.2rem] md:text-[1.5rem] text-[#155458] font-bold">Back</span>
        </a>
    </div>
    <div class="flex h-[1.5rem] items-center gap-4">
        <a id="next-button" href="{{ route('form.pembayaran') }}" class="flex items-center gap-4">
            <span class="text-[0.8rem] sm:text-[1.2rem] md:text-[1.5rem] text-[#155458] font-bold">Next</span>
            <img src="{{ asset('images/next.png') }}" alt="Next" class="h-[0.8rem] sm:h-[1.2rem] md:h-[1.5rem] w-auto">
        </a>
    </div>
</div>



@endsection