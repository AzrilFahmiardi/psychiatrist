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

            <div class="flex flex-col gap-16 items-center justify-center w-[85vw] md:h-[400px] border-2 border-white rounded-[2rem] bg-[#fafafa99] mt-5 mb-10">
                <h1 class="text-[3rem] text-center font-bold bg-title-gradient text-transparent bg-clip-text">Fasilitas Konseling<br>Sekolah Vokasi UGM</h1>
                @if(Auth::check())
                <a href="/form/persetujuan" class="text-[#51B2B8] font-semibold bg-[#FAFAFA] py-3 px-4 rounded-xl hover:scale-110 transition duration-300 ease-in-out">Daftar sekarang</a>
                @else 
                    <button id="loginPopupButton" class="text-[#51B2B8] font-semibold bg-[#FAFAFA] py-3 px-4 rounded-xl hover:scale-110 transition duration-300 ease-in-out">
                        Daftar sekarang
                    </button>
                    <div id="loginPopup" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
                        <div class="bg-white p-6 rounded-xl shadow-lg w-96">
                            <h3 class="text-lg font-semibold">Silahkan login terlebih dahulu</h3>
                            <p class="text-sm">Anda harus login untuk melanjutkan pendaftaran.</p>
                            <div class="mt-4">
                                <a href="/login" class="text-white py-1 px-2 rounded-md bg-blue-500 hover:bg-blue-400">Login</a>
                                <button onclick="closePopup()" class="ml-2 text-white py-1 px-2 rounded-md bg-red-500 hover:bg-red-400">Tutup</button>
                            </div>
                        </div>
                    </div>        
                        <script>
                            document.getElementById('loginPopupButton').onclick = function() {
                                document.getElementById('loginPopup').classList.remove('hidden');
                            };
                            function closePopup() {
                                document.getElementById('loginPopup').classList.add('hidden');
                            }
                        </script>
                    @endif    
            </div>
            
            <div class="w-[85vw] h-[300px] grid grid-cols-3 gap-4">
                <div class="col-span-1 space-y-7">
                    @if(Auth::check())
                    <div class="bg-[#FAFAFA] py-5 px-4 rounded-xl">
                        <h2 class="mb-3 font-bold text-[1.2rem] text-[#155458]">Jadwal anda</h2>
                        <p class="text-[#4F4F4F] font-semibold">dr. Azril Fahmiardi, Sp.Kj.</p>
                        <p class="text-[#4F4F4F] text-[0.8rem]">Senin, 09 December 2024</p>
                        <p class="text-[#4F4F4F] text-[0.8rem]">Pukul 09:00-10:00 WIB</p>
                    </div>
                    @else 
                        <div class="bg-[#FAFAFA] py-5 px-4 rounded-xl min-h-[140px]">
                            <h2 class="mb-3 font-bold text-[1rem] text-[#155458]">Silahkan login dulu untuk melihat jadwal anda</h2>
                        </div>
                    @endif
                    @if(Auth::check())
                    <div class="bg-[#FAFAFA] py-5 px-4 rounded-xl">
                        <h2 class="mb-3 font-bold text-[1.2rem] text-[#155458]">Hasil Konseling</h2>
                            <p class="text-[#4F4F4F] font-semibold">dr. Azril Fahmiardi, Sp.Kj.</p>
                            <div class="flex justify-between">
                                <p class="text-[#4F4F4F] text-[0.8rem]">Senin, 09 December 2024</p>
                                <a href="" class="text-[#155458] text-[0.8rem] flex items-center gap-2 hover:underline">Lihat hasil <span><img src="images/right_arrow.png" alt=""></span></a>
                            </div>
                            <hr class="my-3">
                            <p class="text-[#4F4F4F] font-semibold">dr. Azril Fahmiardi, Sp.Kj.</p>
                            <div class="flex justify-between">
                                <p class="text-[#4F4F4F] text-[0.8rem]">Senin, 09 December 2024</p>
                                <a href="" class="text-[#155458] text-[0.8rem] flex items-center gap-2 hover:underline">Lihat hasil <span><img src="images/right_arrow.png" alt=""></span></a>
                            </div>
                    </div>
                    @else 
                    <div class="bg-[#FAFAFA] py-5 px-4 rounded-xl min-h-[170px]">
                        <h2 class="mb-3 font-bold text-[1rem] text-[#155458]">Silahkan login dulu untuk melihat Hasil Konseling</h2>
                    </div>
                    @endif
                    
                </div>
                <div class="col-span-2 py-3 px-5 bg-[#FAFAFA] rounded-xl">
                    <div class="relative flex justify-between">
                        <h2 class="mb-3 font-bold text-[1.8rem] text-[#4F4F4F] mx-auto">Jadwal Konseling dan Dokter yang Tersedia</h2>
                    </div>
                    <div >
                        <form action="{{ route('jadwal.filter') }}" method="GET" class="w-full grid grid-cols-5 gap-5 mb-5">
                            @csrf
                            <select id="psikolog" name="psikolog" class="col-span-2 w-full text-xs h-7 border-[1px] border-[#4F4F4F] text-[#4F4F4F] rounded-2xl px-4">
                                <option value="none">Pilih Psikolog</option>
                                @foreach ($psikologs as $psikolog)
                                    <option value="{{ $psikolog->id }}">
                                        {{ $psikolog->name }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="date" id="tanggal" name="tanggal" class="col-span-2 w-full text-xs h-7 border-[1px] border-[#4F4F4F] text-[#4F4F4F] rounded-2xl px-4">
                            <button type="submit" class="col-span-1 font-bold text-white bg-[#155458] px-3 py-1 rounded-md">Cari</button>
                        </form>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        @if ($jadwals && $jadwals->count() > 0)
                            @foreach ($jadwals as $jad)
                                @if ($jad->psikolog)
                                <x-jadwalCard 
                                :name="$jad->psikolog->name"
                                :time="(\Carbon\Carbon::parse($jad->waktu)->setTimezone('Asia/Jakarta')->format('H:i') . ' WIB')"
                            />
                                @else
                                    <p>No psychologist assigned</p>
                                @endif
                            @endforeach
                        @else
                            <p>No schedules available</p>
                        @endif

                    </div>

                </div>
            </div>
        </div>
      </div>
</body>
</html>