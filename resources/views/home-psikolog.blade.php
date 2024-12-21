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

    {{-- Flash Message Container --}}
  <div id="flash-message-container" class="absolute top-5 left-0 right-0">
    @if(session('error'))
    <div id="error-message" class="bg-red-500 text-white py-3 px-4 rounded-xl w-fit mx-auto transition-all duration-500">
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
    <div class="bg-login-gradient font-poppins px-10">
        <div class="min-h-screen w-full flex flex-col items-center">
            {{-- NAVBAR --}}
            @if (Auth::check())
            <nav class="flex justify-between w-full py-7 font-poppins text-[#FAFAFA] text-xl px-20">
                <a href="/" class="text-shadow-lg font-bold">SV UGM</a>
                <div class="flex gap-7">
                    <a href="/" class="font-bold">Home</a>
                    <a href="{{ route('agenda.psikolog') }}">Agenda</a>
                </div>
                <a href="{{ route('nonPasien.logout') }}" class="font-bold bg-[#155458be] px-4 py-1 rounded-md hover:bg-[#1554588e]">{{ Auth::user()->name }}</a>
            </nav>
            @else
                <nav class="flex justify-between w-full py-7 font-poppins text-[#FAFAFA] text-xl px-20">
                    <a href="/" class="text-shadow-lg font-bold">SV UGM</a>
                    <div class="flex gap-7">
                        <a href="/" class="font-bold">Home</a>
                        <a href="#" onclick="showLoginModal(event)">Riwayat</a> <!-- Trigger modal -->
                    </div>
                    <a href="/login2" class="font-bold bg-[#155458] px-4 py-1 rounded-md">Login</a>
                </nav>
                
                <!-- Modal -->
                <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
                    <div class="bg-white p-6 rounded-md text-center w-[350px]">
                        <p class="text-lg font-bold text-[#4F4F4F]">Login untuk melanjutkan</p>
                        <p class="text-sm text-[#4F4F4F] my-5">Anda harus login untuk melihat riwayat</p>
                        <div class="mt-4">
                            <a href="/login" class="bg-[#155458] px-4 py-2 rounded-md text-white hover:bg-[#155458c2]">Login</a>
                            <button onclick="closePopup()" class="border border-[#155458] px-4 py-2 rounded-md text-[#155458] ml-2 hover:bg-[#1554582d]">Cancel</button>
                        </div>
                    </div>
                </div>

                <!-- JavaScript for Modal -->
                <script>
                    function showLoginModal(event) {
                        event.preventDefault(); // Prevent default anchor action
                        document.getElementById('loginModal').classList.remove('hidden');
                    }

                    function closePopup() {
                        document.getElementById('loginModal').classList.add('hidden');
                    }
                </script>
            @endif

            {{-- END NAVBAR --}}


            {{-- HERO --}}
            <div class="flex flex-col gap-16 items-center justify-center w-[85vw] md:h-fit py-10 border-2 border-white rounded-[2rem] bg-[#fafafa99] mt-5 mb-10">
                <h1 class="text-[3rem] text-center font-bold bg-title-gradient text-transparent bg-clip-text">Fasilitas Konseling<br>Sekolah Vokasi UGM</h1> 
            </div>
            
            {{-- CONTENT --}}
            <div class="w-[85vw] h-[550px] grid grid-cols-3 gap-4">
                {{-- LEFT CONTENT --}}
                <div class="bg-[#FAFAFA] py-5 px-5 rounded-xl h-full">
                    <h2 class="mb-1 font-bold text-[1.2rem] text-[#155458]">Agenda anda</h2>   
                    @if ($bookings && $bookings->isNotEmpty())
                        @foreach ($bookings as $book)
                        @php
                            $statusClass = '';
                            $statusBgColor = '';
                            $statusIcon = '';
                            $statusInfo = '';
                
                            if (($book->status === 'submitted' || $book->status === 'scheduled') && now()->greaterThan($book->jadwal->waktu)) {
                                $statusClass = 'text-green-500';
                                $statusBgColor = 'bg-[#155458]';
                                $statusIcon = 'images/warning_green.png';
                                $statusInfo = 'Menunggu hasil konsultasi dari anda';
                            } elseif($book->status === 'submitted') {
                                $statusClass = 'text-yellow-700';
                                $statusBgColor = 'bg-green-700';
                                $statusIcon = 'images/warning_yellow.png';
                                $statusInfo = 'Siap untuk pertemuan';
                            } elseif($book->status === 'scheduled') {
                                $statusClass = 'text-orange-600';
                                $statusBgColor = 'bg-yellow-600';
                                $statusIcon = 'images/warning_orange.png';
                                $statusInfo = 'Admin sedang melakukan pengecekan bukti pembayaran';
                            }
                        @endphp
                        <div class="text-[#4F4F4F] pr-2 pb-2">
                            <p class="font-semibold text-[1.1rem] mt-5">{{ $book->pasien->name }}</p>
                            <p class="text-[0.9rem]">{{ \Carbon\Carbon::parse($book->jadwal->waktu)->isoFormat('dddd, D MMMM YYYY') }}</p>
                            <p class="text-[0.9rem]">
                                {{ \Carbon\Carbon::parse($book->jadwal->waktu)->addHours(7)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($book->jadwal->waktu)->addHours(8)->format('H:i') }} WIB
                            </p>
                            <div class="flex justify-between">
                                <p class="flex items-center gap-2 {{ $statusClass }} text-[0.7rem] my-2">
                                    <img alt="infoLogo" class="h-[1em] w-[1em] inline-block" src="{{ $statusIcon }}">
                                    {{ $statusInfo }}
                                </p>
                                <p class="text-[0.9rem] text-[#FAFAFA] px-2 py-1 {{ $statusBgColor }} rounded">{{ $book->status }}</p>
                            </div>
                        </div>
                        <hr>
                        @endforeach
                    @else
                        <p class="text-gray-700 text-sm">Tidak ada agenda</p>
                    @endif
                </div>
                
                
                
             
                {{-- RIGHT CONTENT : JADWAL --}}
                <div class="col-span-2 py-3 px-5 bg-[#FAFAFA] rounded-xl flex flex-col h-full">
                    <div class="relative flex justify-between">
                        <h2 class="mb-3 font-bold text-[1rem] text-[#4F4F4F] mx-auto">SIKOLOV WEEK AGENDA</h2>
                    </div>
                    <div class="flex-grow">
                        <iframe 
                            src="https://calendar.google.com/calendar/embed?height=600&wkst=1&ctz=Asia%2FJakarta&showPrint=0&mode=WEEK&showTz=0&showTabs=0&showTitle=0&src=ZDI5NTA3OGY3NmE2MWFkODg3NzRkYmI4ZGVlYjFmNDMwYWNlMTMzNTE1OGNlZTI5ODk3M2ZhMWQ0MWY5ZmIxYUBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&color=%23D50000" 
                            style="border-width:0" 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            scrolling="no">
                    </iframe>
                    </div>
                </div>
                
            </div>
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