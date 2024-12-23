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
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-[#CDCDCD]" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full md:w-[16em] flex flex-col gap-3 justify-between">
        <label class="text-xs md:text-xs lg:text-base">Pilih jadwal</label>

        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-[#CDCDCD]" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full md:w-[16em] flex flex-col gap-3 justify-between">
        <label class="text-xs md:text-xs lg:text-base">Ketentuan & submit</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-[#CDCDCD]" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full md:w-[16em] flex flex-col gap-3 justify-between">
        <label class="text-xs md:text-xs lg:text-base">Pembayaran</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-[#CDCDCD]" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>

{{-- KONTEN FORM --}}
<div class="w-full">
    <h1 class="text-center text-[#155458] text-xs sm:text-md md:text-xl font-bold my-10">Lembar Persetujuan Melakukan Konseling (informed Consent)</h1>
    <div class="flex flex-col gap-5">
        <div class="w-4/5 md:w-2/3 mx-auto border border-[#4F4F4F] rounded-2xl p-5">
            <p class="mb-5 text-xs sm:text-sm md:text-base">Saya memahami bahwa konseling/konsultasi berbeda dengan curhat pada umumnya, sehingga saya akan memanfaatkan waktu konseling untuk benar-benar membantu saya menentukan alternatif solusi dalam menyelesaikan masalah saya.</p>
            <input id="persetujuan-1" type="checkbox">
            <label for="persetujuan-1" class="text-[#155458] font-semibold text-xs sm:text-sm md:text-base">Saya mengerti</label>
        </div>
        <div class="w-4/5 md:w-2/3 mx-auto border border-[#4F4F4F] rounded-2xl p-5">
            <p class="mb-5 text-xs sm:text-sm md:text-base">Psikolog tidak akan membagikan data personal saya kepada siapapun kecuali atas persetujuan saya atau diminta oleh badan hukum. Apabila saya berada dalam situasi krisis, yaitu situasi yang dapat berakibat membahayakan nyawa saya sendiri atau orang lain, maka psikolog berhak menginformasikan kondisi saya kepada orang lain (Dosen Pembimibing Akademik (DPA)/orang tua).</p>
            <input id="persetujuan-2" type="checkbox">
            <label for="persetujuan-2" class="text-[#155458] font-semibold text-xs sm:text-sm md:text-base">Saya mengerti</label>
        </div>
        <div class="w-4/5 md:w-2/3 mx-auto border border-[#4F4F4F] rounded-2xl p-5">
            <p class="mb-5 text-xs sm:text-sm md:text-base">Jika dalam situasi dan kondisi tertentu, psikolog dapat merujuk saya untuk melakukan konseling dengan tenaga profesional lain (psikolog lain atau psikiater)</p>
            <input id="persetujuan-3" type="checkbox">
            <label for="persetujuan-3" class="text-[#155458] font-semibold text-xs sm:text-sm md:text-base">Saya mengerti</label>
        </div>
    </div>
    

</div>


{{-- TOMBOL --}}
<div class="absolute w-full flex justify-between px-10 bottom-16">
    <div class="flex h-[1.5rem] items-center gap-4">
        <a href="/" class="flex items-center gap-2 md:gap-4">
            <img src="{{ asset('images/back.png') }}" class="h-[0.8rem] sm:h-[1.2rem] md:h-[1.5rem] w-auto" alt="Back">
            <span class="text-[0.8rem] sm:text-[1.2rem] md:text-[1.5rem] text-[#155458] font-bold">Back to home</span>
        </a>
    </div>
    <div class="flex h-[1.5rem] items-center gap-2 md:gap-4">
        <a id="next-button" href="{{ route('form.data_diri') }}" class="flex items-center gap-4">
            <span class="text-[0.8rem] sm:text-[1.2rem] md:text-[1.5rem] text-[#155458] font-bold">Next</span>
            <img src="{{ asset('images/next.png') }}" class="h-[0.8rem] sm:h-[1.2rem] md:h-[1.5rem] w-auto" alt="Next">
        </a>
    </div>
</div>



@endsection