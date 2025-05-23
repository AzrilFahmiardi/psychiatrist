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
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>

{{-- KONTEN FORM --}}
<form action="{{ route('submit.booking') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
    @csrf
    <div class="relative flex flex-col items-center w-fit mx-auto justify-start">
        <h1 class="text-center text-[#155458] text-xs sm:text-md md:text-xl font-bold mt-10 mb-3">Pembayaran</h1>
        
        @if (Auth::user()->trial_left > 0)
            {{-- GRATIS BELUM HABIS --}}
            <h2 class="text-center text-[#155458] text-[1.8rem] sm:text-[2.5rem] md:text-[3rem] font-bold my-10 line-through">Rp. 150.000,00</h2>
            <p>Anda dapat mengakses layanan ini secara gratis sampai hingga {{ Auth::user()->trial_left}} kali pertemuan</p>
        @else
            {{-- GRATIS HABIS --}}
            <h2 class="text-center text-[#155458] text-[1.8rem] sm:text-[2.5rem] md:text-[3rem] font-bold my-10">Rp. 150.000,00</h2>
            <div class="flex flex-col gap-5 border-2 border-[#4F4F4F]  w-[80%] md:w-[580px] py-3 px-4 rounded-xl text-[#4F4F4F] font-poppins">
                <p class="text-xs sm:text-sm md:text-base">Transfer pembayaran ke</p>
                <div class="flex justify-between items-center flex-wrap gap-2">
                    <img src="{{ asset('images/bri.png') }}" alt="BANK BRI" class="w-3/5 md:w-[200px]">
                    <p id="account-number" class="flex items-center gap-3 text-xs sm:text-sm md:text-base">
                        123456789098631s
                        <span class="cursor-pointer"><img src="{{ asset('images/copy.png') }}" alt="salin text" id="copy-button"></span>
                    </p>                
                </div>
            </div>

            {{-- FORM UPLOAD BUKTI PEMBAYARAN --}}
            <div class="flex flex-col items-start gap-3 absolute left-10 md:left-0 -bottom-10 cursor-pointer">
                <label for="bukti_pembayaran" class="text-[#4F4F4F] text-[0.8rem] font-semibold cursor-pointer flex items-center gap-3">
                    <img src="{{ asset('images/upload.png') }}" alt="upload" class="w-5">
                    Upload bukti pembayaran
                    <span id="file-name" class="text-[#4F4F4F] text-sm font-normal ml-2"></span>
                </label>
                <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*" class="visually-hidden" required>
            </div>
        @endif
    </div>

    {{-- TOMBOL --}}
    <div class="absolute w-full flex justify-between px-10 bottom-16">
        <div class="flex h-[1.5rem] items-center gap-4">
            <a href="{{ route('form.ketentuan_submit') }}" class="flex items-center gap-4">
                <img src="{{ asset('images/back.png') }}" alt="Back" class="h-[0.8rem] sm:h-[1.2rem] md:h-[1.5rem] w-auto">
                <span class="text-[0.8rem] sm:text-[1.2rem] md:text-[1.5rem] text-[#155458] font-bold">Back</span>
            </a>
        </div>
        <div class="flex h-[0.8rem] sm:h-[1.2rem] md:h-[1.5rem] items-center gap-4">
            <button type="submit" class="flex items-center gap-4 font-poppins bg-[#155458] text-[#FAFAFA] py-2 px-4 rounded-xl font-bold text-[0.8rem] sm:text-[1.2rem] md:text-[1.5rem]">
                Submit
            </button>
        </div>
    </div>
</form>

{{-- Display error message --}}
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4 w-[80%] md:w-[580px] mx-auto" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ $errors->first() }}</span>
        <div class="mt-2">
            <a href="{{ route('login') }}" class="inline-block bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300">Login</a>
        </div>
    </div>
@endif

<span id="file-error" class="text-red-500 text-sm"></span>

<script>
    document.getElementById('bukti_pembayaran').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const errorMessage = document.getElementById('file-error');
        
        if (file && file.size > 2 * 1024 * 1024) { // Maksimal 2MB
            errorMessage.textContent = 'Ukuran file terlalu besar. Maksimal 2MB.';
            event.target.value = '';
        } else {
            errorMessage.textContent = '';
        }

        const fileName = file ? file.name : 'Belum ada file dipilih';
        document.getElementById('file-name').textContent = fileName;
    });

    document.getElementById('copy-button').addEventListener('click', function() {
        // Ambil teks yang akan disalin
        const textToCopy = document.getElementById('account-number').innerText;

        // Gunakan API Clipboard untuk menyalin teks
        navigator.clipboard.writeText(textToCopy).then(() => {
            alert('Teks berhasil disalin ke clipboard!');
        }).catch(err => {
            console.error('Gagal menyalin teks:', err);
        });
    });
</script>

    
@endsection