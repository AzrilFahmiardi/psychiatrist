<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>SIKOLOV</title>
</head>
<body>
    @php
    use Carbon\Carbon;

    $formattedDate = '';
    $formattedTime = '';
    
    if(Auth::check() && isset($bookingLastest)) {
        $jadwal = Carbon::parse($bookingLastest->jadwal->waktu);
        $jadwal->timezone('Asia/Jakarta');
        Carbon::setLocale('id'); 
        $formattedDate = $jadwal->translatedFormat('l, d F Y');
        $formattedTime = $jadwal->format('H:i') . '-' . $jadwal->addHour()->format('H:i') . ' WIB';
    }
@endphp

    {{-- Flash Message Container --}}
  <div id="flash-message-container" class="absolute top-5 left-0 right-0 z-50">
    @if(session('error'))
    <div id="error-message" class="bg-red-500 text-white py-3 px-4 rounded-xl w-fit mx-auto transition-all duration-500 z-50">
        <p class="text-sm">{{ session('error') }}</p>
    </div>
    @endif

    @if(session('success'))
    <div id="success-message" class="bg-green-500 text-white py-3 px-4 rounded-xl w-fit mx-auto transition-all duration-500">
        <p class="text-sm">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('status'))
    <div id="status-message" class="bg-blue-500 text-white py-3 px-4 rounded-xl w-fit mx-auto transition-all duration-500">
        <p class="text-sm">{{ session('status') }}</p>
    </div>
    @endif

    @if(session('warning'))
    <div id="warning-message" class="bg-yellow-500 text-white py-3 px-4 rounded-xl w-fit mx-auto transition-all duration-500">
        <p class="text-sm">{{ session('warning') }}</p>
    </div>
    @endif

    @if(session('info'))
    <div id="info-message" class="bg-blue-300 text-white py-3 px-4 rounded-xl w-fit mx-auto transition-all duration-500">
        <p class="text-sm">{{ session('info') }}</p>
    </div>
    @endif
</div>

<img src="images/elips.png" class="fixed top-0 right-0 w-1/3 md:w-1/4 lg:w-1/5 z-0" alt="">
    {{-- <img src="images/elips2.png" class="fixed bottom-0 left-0 w-1/3 md:w-1/4 lg:w-1/5 z-0" alt=""> --}}

    <div class="bg-login-gradient h-[900px] min-h-screen font-poppins px-10 z-10">
        <div class="w-full flex flex-col items-center">
            <div class="w-full z-40">
                <x-navbar class="text-[0.8rem] sm:text-[1rem] md:text-[1.2rem] lg:text-[1.5rem]"></x-navbar>
            </div>

            <div class="flex flex-col gap-5 sm:gap-7 md:gap-10 lg:gap-16 items-center justify-center w-[85vw] h-[200px] sm:h-[300px] md:h-[400px] border-2 border-white rounded-[2rem] z-10 bg-[#fafafa99] mt-5 mb-10">
                <div>
                    <h1 class="text-[2rem] sm:text-[3rem]  md:text-[5.5rem] text-center font-bold bg-title-gradient text-transparent bg-clip-text">SIKOLOV</h1>
                    <h2 class="text-[0.5rem] sm:text-[0.8rem]  md:text-[1.2rem] text-center font-bold bg-title-gradient text-transparent bg-clip-text">Fasilitas Konseling Sekolah Vokasi UGM</h2>
                    <p class="text-[0.5rem] md:text-[0.9rem] text-gray-700  text-center  mt-2 transition-all duration-300">Aplikasi ini digunakan untuk membantu mahasiswa Sekolah Vokasi yang membutuhkan layanan konseling dengan menggunakan Google Calendar sebagai pengatur jadwal</p>
                    
                </div>
                
                @if(Auth::check())
                <a href="/form/persetujuan" class="text-[0.5rem] sm:text-[0.8rem]  md:text-[1.2rem] text-[#51B2B8] font-semibold bg-[#FAFAFA] py-3 px-4 rounded-xl hover:scale-110 transition duration-300 ease-in-out">Daftar sekarang</a>
                @else 
                <button id="loginPopupButton" class="text-[#51B2B8] font-semibold bg-[#FAFAFA] py-3 px-4 rounded-xl hover:scale-110 transition duration-300 ease-in-out">
                    Daftar sekarang
                </button>
                <div id="loginPopup" class="fixed inset-0 bg-black bg-opacity-25 backdrop-blur-sm flex justify-center items-center hidden">
                    <div class="bg-white p-6 rounded-md text-center w-[350px]">
                        <p class="text-lg font-bold text-[#4F4F4F]">Login untuk melanjutkan</p>
                        <p class="text-sm text-[#4F4F4F] my-5">Anda harus login untuk melanjutkan ke pendaftaran</p>
                        <div class="mt-4">
                            <a href="/login" class="bg-[#155458] px-4 py-2 rounded-md text-white hover:bg-[#155458c2]">Login</a>
                            <button onclick="closeModal()" class="border border-[#155458] px-4 py-2 rounded-md text-[#155458] ml-2 hover:bg-[#1554582d]">Cancel</button>
                        </div>
                    </div>
                </div>       
                <script>
                    document.getElementById('loginPopupButton').onclick = function() {
                        document.getElementById('loginPopup').classList.remove('hidden');
                    };
                    function closeModal() {
                        document.getElementById('loginPopup').classList.add('hidden');
                    }
                </script>
                    @endif    
            </div>
            
            {{-- KONTEN --}}
            <div class="w-[85vw] h-[300px] grid grid-cols-1 md:grid-cols-3 gap-2 ">
                <div class="md:col-span-1 space-y-2">
                    
                    <div class="bg-[#FAFAFA] py-5 px-4 rounded-xl min-h-[100px] ">
                        <h2 class="mb-1 font-bold text-[0.5rem] md:text-[1.2rem] text-[#155458]">Jadwal anda</h2>
                            @if(Auth::check())
                                @if(isset($bookingLastest))
                                    <p class="text-[#4F4F4F] text-[0.5rem] md:text-base font-semibold">{{ $bookingLastest->psikolog->name }}</p>
                                    <p class="text-[#4F4F4F] text-[0.45rem] md:text-[0.6rem] lg:text-[0.8rem]">{{ $formattedDate }}</p>
                                    <div class="flex justify-between items-center">
                                        <p class="text-[#4F4F4F] text-[0.45rem] md:text-[0.6rem] lg:text-[0.8rem]">{{ $formattedTime }}</p>
                                        <a href="{{ route('riwayat.booking') }}" 
                                        class="hidden flex text-[#155458] text-[0.5rem] lg:text-[0.8rem] items-center gap-2 hover:underline">
                                            Jadwal lainnya 
                                            <span>
                                                <img src="images/right_arrow.png" alt="">
                                            </span>
                                        </a>
                                    </div>
                                @else
                                    <p class="text-[#4F4F4F] text-[0.6rem] lg:text-[0.8rem]">Belum ada jadwal yang dibooking</p>
                                @endif
                            @else
                                <p class="text-[#4F4F4F] text-[0.6rem] lg:text-[0.8rem]">Silahkan login untuk melihat jadwal anda</p>
                            @endif
                    </div>
                    
                    
                    <div class="bg-[#FAFAFA] py-5 px-4 rounded-xl min-h-[120px]">
                        <h2 class="mb-1 font-bold text-[0.5rem] md:text-[1.2rem] text-[#155458]">Hasil Konseling</h2>
                        @if(Auth::check())
                            @if(isset($konsultasi))
                                <p class="text-[#4F4F4F] font-semibold text-[0.5rem] md:text-base">{{ $konsultasi->booking->psikolog->name }}</p>
                                <p class="text-[#4F4F4F] text-[0.45rem] md:text-[0.6rem] lg:text-[0.8rem]">
                                    {{ \Carbon\Carbon::parse($konsultasi->booking->waktu)->isoFormat('dddd, D MMMM YYYY') }}
                                </p>
                                <p class="text-[#4F4F4F] text-[0.45rem] md:text-[0.6rem] lg:text-[0.8rem] lg:mt-2 truncate">Hasil : {{ $konsultasi->hasil_konsultasi }}</p>
                                <hr class="my-3">
                                <a href="{{ route('riwayat.booking') }}" class="text-[#155458] text-[0.45rem] md:text-[0.6rem] lg:text-[0.8rem] flex items-center gap-2 hover:underline">Hasil lainnya <span><img src="images/right_arrow.png" alt=""></span></a>
                            @else
                                <p class="text-[#4F4F4F] text-[0.45rem] md:text-[0.6rem] lg:text-[0.8rem]">Belum ada hasil konsultasi</p>
                            @endif
                        @else
                            <p class="text-[#4F4F4F] text-[0.45rem] md:text-[0.6rem] lg:text-[0.8rem]">Silahkan login untuk melihat hasil konseling</p>
                        @endif


                    </div>
                   
                    
                    
                </div>
                {{-- JADWAL --}}
                <div class="md:col-span-2 py-3 px-5 bg-[#FAFAFA] rounded-xl">
                    
                    <div class="relative flex justify-between">
                        <h2 class="mb-3 font-bold text-[0.6rem] md:text-[1rem] lg:text-[1.3rem]  text-[#4F4F4F] mx-auto">Jadwal Konseling dan Psikolog yang Tersedia</h2>
                    </div>
                    <div >
                        <form action="{{ route('jadwal.filter') }}" method="GET" class="w-full grid grid-cols-5 gap-2 md:gap-5 mb-2 md:mb-5">
                            @csrf
                            <div class="relative col-span-2">
                                <select id="psikolog" name="psikolog" class=" w-full text-[0.5rem] md:text-xs h-7 border-[1px] border-[#4F4F4F] text-[#4F4F4F] rounded-2xl px-1 sm:px-2 md:px-3 lg:px-4 appearance-none">
                                    <option value="none">Pilih Psikolog</option>
                                    @foreach ($psikologs as $psikolog)
                                        <option value="{{ $psikolog->id }}" {{ isset($selectedPsikolog) && $selectedPsikolog == $psikolog->id ? 'selected' : '' }}>
                                            {{ $psikolog->name }}
                                        </option>
                                    @endforeach
    
                                </select>
                                <img src="{{ asset('images/down-arrow.png') }}" alt="" class="absolute bottom-2 right-4">

                            </div>
                           
                            @php
                            // Ambil tanggal hari ini dalam format yyyy-mm-dd
                            $today = \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d');
                            @endphp
                            
                            <input type="date" 
                                id="tanggal" 
                                name="tanggal" 
                                class="col-span-2 w-full text-[0.5rem] md:text-xs h-7 border-[1px] border-[#4F4F4F] text-[#4F4F4F] rounded-2xl px-1 sm:px-2 md:px-3 lg:px-4" 
                                value="{{ request('tanggal', $today) }}">      
                                {{-- value="Pilih tanggal konseling">                                      --}}
                                <button type="submit" class="col-span-1 font-bold text-white bg-[#155458] text-[0.5rem] md:text-xs px-1 md:px-3 md:py-1 rounded-md">Cari</button>
                        </form>
                    </div>
                    <div class="grid grid-cols-2 gap-1 md:gap-2 lg:gap-3">
                        @if ($jadwals && $jadwals->count() > 0)
                            @foreach ($jadwals as $jad)
                                @if ($jad->psikolog)
                                    <x-jadwalCard 
                                        :name="$jad->psikolog->name"
                                        :time="(\Carbon\Carbon::parse($jad->waktu)->setTimezone('Asia/Jakarta')->format('H:i') . ' WIB')"
                                        :status="$jad->status"
                                    />
                                @else
                                    <p class="text-[0.5rem] md:text-[0.6rem] lg:text-[0.8rem]">No psychologist assigned</p>
                                @endif
                            @endforeach
                        @else
                            <p class="text-[0.5rem] md:text-[0.6rem] lg:text-[0.8rem]">No schedules available</p>
                        @endif

                    </div>

                </div>
            </div>
            
            
        </div>
        <div class="bg-login-gradient fixed bottom-0 left-0 w-full text-[#FAFAFA] flex gap-5 justify-end text-xs md:text-sm bg-red-500">
            <a class=" hover:underline" href="/term-of-service">Term of Service</a>
            <a class=" hover:underline" href="/privacy-policy">Privacy Policy</a>
        </div>
      </div>
      
      
      <script>
        document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss messages after 5 seconds
        const messages = document.querySelectorAll('#flash-message-container > div');
        
        messages.forEach(function(message) {
            // Fade in
            setTimeout(() => {
                message.classList.add('opacity-0', 'h-0', 'py-0');
            }, 5000);  // <-- This is where the 5-second timing is set

            // Remove from DOM
            setTimeout(() => {
                message.remove();
            }, 5000);  // <-- This is slightly after the fade-out to complete the animation
            });
        });
      </script>
</body>
</html>