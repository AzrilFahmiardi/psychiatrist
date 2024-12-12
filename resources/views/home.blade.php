<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Psychiatrist</title>
</head>
<body>
    <div class="bg-login-gradient font-poppins px-10">
        <div class="min-h-screen w-full flex flex-col items-center">
            <x-navbar></x-navbar>

            <div class="flex flex-col gap-16 items-center justify-center w-[85vw] md:h-[400px] border-2 border-white rounded-[2rem] bg-[#fafafa99] my-10">
                <h1 class="text-[3rem] text-center font-bold bg-title-gradient text-transparent bg-clip-text">Fasilitas Konseling<br>Sekolah Vokasi UGM</h1>
                <a href="/form/persetujuan" class="text-[#51B2B8] font-semibold bg-[#FAFAFA] py-3 px-4 rounded-xl">Daftar sekarang</a>
            </div>
            <div class="w-[85vw] h-[300px] grid grid-cols-3 gap-4">
                <div class="col-span-1 space-y-7">
                    <div class="bg-[#FAFAFA] py-5 px-4 rounded-xl">
                        <h2 class="mb-3 font-bold text-[1.2rem] text-[#155458]">Jadwal anda</h2>
                        <p class="text-[#4F4F4F] font-semibold">dr. Azril Fahmiardi, Sp.Kj.</p>
                        <p class="text-[#4F4F4F] text-[0.8rem]">Senin, 09 December 2024</p>
                        <p class="text-[#4F4F4F] text-[0.8rem]">Pukul 09:00-10:00 WIB</p>
                    </div>
                    <div class="bg-[#FAFAFA] py-5 px-4 rounded-xl">
                        <h2 class="mb-3 font-bold text-[1.2rem] text-[#155458]">Hasil Konseling</h2>
                            <p class="text-[#4F4F4F] font-semibold">dr. Azril Fahmiardi, Sp.Kj.</p>
                            <div class="flex justify-between">
                                <p class="text-[#4F4F4F] text-[0.8rem]">Senin, 09 December 2024</p>
                                <a href="" class="text-[#155458] text-[0.8rem] flex items-center gap-2">Lihat hasil <span><img src="images/right_arrow.png" alt=""></span></a>
                            </div>
                            <hr class="my-3">
                            <p class="text-[#4F4F4F] font-semibold">dr. Azril Fahmiardi, Sp.Kj.</p>
                            <div class="flex justify-between">
                                <p class="text-[#4F4F4F] text-[0.8rem]">Senin, 09 December 2024</p>
                                <a href="" class="text-[#155458] text-[0.8rem] flex items-center gap-2">Lihat hasil <span><img src="images/right_arrow.png" alt=""></span></a>
                            </div>
                        
                       
                    </div>
                </div>
                <div class="col-span-2 py-3 px-5 bg-[#FAFAFA] rounded-xl">
                    <div class="relative flex justify-between">
                        <h2 class="mb-3 font-bold text-[1.8rem] text-[#4F4F4F] mx-auto">Jadwal Konseling dan Dokter yang Tersedia</h2>
                    </div>
                    <div class="w-full grid grid-cols-2 gap-5 mb-5">
                        <select id="psikolog" name="psikolog" class="w-full text-xs h-7 border-[1px] border-[#4F4F4F] text-[#4F4F4F] rounded-2xl px-4"">
                            <option value="option1">Dr. Azril Fahmiardi</option>
                            <option value="option2">Dr. Shafwan </option>
                            <option value="option3">Dr. Arga</option>
                        </select>
                        <img src="{{ asset('images/down-arrow.png') }}" alt="" class="absolute bottom-[1.1rem] right-10 ">                        
                        <input type="date" id="tanggal" name="tanggal" class="w-full text-xs h-7 border-[1px] border-[#4F4F4F] text-[#4F4F4F] rounded-2xl px-4">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <x-jadwalCard></x-jadwalCard>
                        <x-jadwalCard></x-jadwalCard>
                        <x-jadwalCard></x-jadwalCard>
                        <x-jadwalCard></x-jadwalCard>
                        <x-jadwalCard></x-jadwalCard>
                        <x-jadwalCard></x-jadwalCard>

                    </div>

                </div>
            </div>
        </div>
      </div>
</body>
</html>