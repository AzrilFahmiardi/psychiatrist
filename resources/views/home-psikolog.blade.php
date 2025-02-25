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
    <div id="flash-message-container" class="fixed top-5 left-0 right-0 z-50">
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

    <img src="images/elips.png" class="fixed top-0 right-0 w-1/3 md:w-1/4 lg:w-1/5 z-0" alt="">
    <img src="images/elips2.png" class="fixed bottom-0 left-0 w-1/3 md:w-1/4 lg:w-1/5 z-0" alt="">

    <div class="bg-login-gradient font-poppins px-4 sm:px-6 md:px-10 min-h-screen">
        <div class="container mx-auto">
            {{-- NAVBAR --}}
@if (Auth::check())
<nav class="w-full py-7 font-poppins text-[#FAFAFA] text-[0.8rem] sm:text-[1rem] md:text-[1.2rem] lg:text-[1.5rem] relative z-30">
    <div class="flex justify-between items-center z-30">
        {{-- <a href="/" class="text-shadow-lg font-bold z-50">SV UGM</a> --}}
        {{-- <img src="{{ asset('images/logo_sikolov_3.png') }}" alt="logo sikolov" class="w-[150px]"> --}}
        <div class="bg-[#155458] rounded-full p-2">
            <img src="{{ asset('images/logo_sikolov_3.png') }}" alt="logo sikolov" class="w-[50px]">

        </div>

        <!-- Hamburger Button -->
        <button type="button" onclick="toggleMenu()" class="md:hidden z-50 relative w-8 h-8 flex justify-center items-center">
            <div id="hamburger" class="flex flex-col justify-between w-6 h-5 transform transition-all duration-300">
                <span class="w-full h-0.5 bg-white transform transition-all duration-300"></span>
                <span class="w-full h-0.5 bg-white transform transition-all duration-300"></span>
                <span class="w-full h-0.5 bg-white transform transition-all duration-300"></span>
            </div>
        </button>

        <div class="hidden md:flex md:items-center md:gap-7">
            <a href="/" class="font-bold">Home</a>
            <a href="{{ route('agenda.psikolog') }}">Agenda</a>
        </div>

        <a href="#" onclick="confirmLogout(event)" class="hidden md:block font-bold bg-[#155458be] px-4 py-1 rounded-md hover:bg-[#1554588e]">
            {{ Auth::user()->name }}
        </a>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="absolute top-full left-0 w-full bg-[#155458] rounded-xl transform transition-all duration-300 -translate-y-full opacity-0 invisible md:hidden shadow-lg z-30">
        <div class="py-4 px-6 space-y-4">
            <a href="/" class="block font-bold hover:text-gray-300 transition-colors">Home</a>
            <a href="{{ route('agenda.psikolog') }}" class="block hover:text-gray-300 transition-colors">Agenda</a>
            <a href="#" onclick="confirmLogout(event)" class="block font-bold bg-white text-[#155458] px-4 py-2 rounded-md hover:bg-gray-100 w-fit">
                {{ Auth::user()->name }}
            </a>
        </div>
    </div>
</nav>
@else
<nav class="w-full py-7 font-poppins text-[#FAFAFA] text-[0.8rem] sm:text-[1rem] md:text-[1.2rem] lg:text-[1.5rem] md:px-20 relative z-30">
    <div class="flex justify-between items-center z-30">
        {{-- <a href="/" class="text-shadow-lg font-bold z-50">SV UGM</a> --}}
        {{-- <img src="{{ asset('images/logo_sikolov_3.png') }}" alt="logo sikolov" class="w-[150px]"> --}}
        <div class="bg-[#155458] rounded-full p-2">
            <img src="{{ asset('images/logo_sikolov_3.png') }}" alt="logo sikolov" class="w-[50px]">

        </div>
        <!-- Hamburger Button -->
        <button type="button" onclick="toggleMenu()" class="md:hidden z-50 relative w-8 h-8 flex justify-center items-center">
            <div id="hamburger" class="flex flex-col justify-between w-6 h-5 transform transition-all duration-300">
                <span class="w-full h-0.5 bg-white transform transition-all duration-300"></span>
                <span class="w-full h-0.5 bg-white transform transition-all duration-300"></span>
                <span class="w-full h-0.5 bg-white transform transition-all duration-300"></span>
            </div>
        </button>

        <div class="hidden md:flex md:items-center md:gap-7">
            <a href="/" class="font-bold">Home</a>
            <a href="#" onclick="showLoginModal(event)">Riwayat</a>
        </div>

        <a href="/login-psikolog" class="hidden md:block font-bold bg-[#155458] px-4 py-1 rounded-md">Login</a>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="absolute top-full left-0 w-full bg-[#155458] rounded-xl transform transition-all duration-300 -translate-y-full opacity-0 invisible md:hidden shadow-lg z-30">
        <div class="py-4 px-6 space-y-4">
            <a href="/" class="block font-bold hover:text-gray-300 transition-colors">Home</a>
            <a href="#" onclick="showLoginModal(event)" class="block hover:text-gray-300 transition-colors">Riwayat</a>
            <a href="/login-psikolog" class="block font-bold bg-white text-[#155458] px-4 py-2 rounded-md hover:bg-gray-100 w-fit">
                Login
            </a>
        </div>
    </div>
</nav>

<!-- Modal -->
<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-md text-center w-[350px]">
        <p class="text-lg font-bold text-[#4F4F4F]">Login untuk melanjutkan</p>
        <p class="text-sm text-[#4F4F4F] my-5">Anda harus login untuk melihat riwayat</p>
        <div class="mt-4">
            <a href="/login" class="bg-[#155458] px-4 py-2 rounded-md text-white hover:bg-[#155458c2]">Login</a>
            <button onclick="closePopup()" class="border border-[#155458] px-4 py-2 rounded-md text-[#155458] ml-2 hover:bg-[#1554582d]">Cancel</button>
        </div>
    </div>
</div>
@endif

<script>
    function toggleMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        const hamburger = document.getElementById('hamburger');
        const spans = hamburger.getElementsByTagName('span');

        if (mobileMenu.classList.contains('-translate-y-full')) {
            mobileMenu.classList.remove('-translate-y-full', 'opacity-0', 'invisible');
            mobileMenu.classList.add('translate-y-0', 'opacity-100', 'visible');
            spans[0].classList.add('rotate-45', 'translate-y-2');
            spans[1].classList.add('opacity-0');
            spans[2].classList.add('-rotate-45', '-translate-y-2');
        } else {
            mobileMenu.classList.remove('translate-y-0', 'opacity-100', 'visible');
            mobileMenu.classList.add('-translate-y-full', 'opacity-0', 'invisible');
            spans[0].classList.remove('rotate-45', 'translate-y-2');
            spans[1].classList.remove('opacity-0');
            spans[2].classList.remove('-rotate-45', '-translate-y-2');
        }
    }

    function showLoginModal(event) {
        event.preventDefault();
        document.getElementById('loginModal').classList.remove('hidden');
    }

    function closePopup() {
        document.getElementById('loginModal').classList.add('hidden');
    }

    function confirmLogout(event) {
        event.preventDefault();
        if (confirm('Apakah Anda yakin ingin logout?')) {
            window.location.href = "{{ route('nonPasien.logout') }}";
        }
    }
</script>
{{-- END NAVBAR --}}

            {{-- HERO --}}
            <div class="flex flex-col items-center justify-center w-full  mx-auto ">
                <div class="w-full px-4 py-8 md:py-12 border-2 border-white rounded-[2rem] bg-[#fafafa99] backdrop-blur-sm">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl text-center font-bold bg-title-gradient text-transparent bg-clip-text transition-all duration-300">SIKOLOV</h1>
                    <h2 class="text-sm sm:text-base md:text-lg lg:text-xl text-center font-bold bg-title-gradient text-transparent bg-clip-text mt-2 transition-all duration-300">Fasilitas Konseling Sekolah Vokasi UGM</h2>
                    <p class="text-[0.5rem] md:text-[0.9rem] text-gray-700  text-center  mt-2 transition-all duration-300">Aplikasi ini digunakan untuk membantu mahasiswa DTEDI yang membutuhkan layanan konseling dengan menggunakan Google Calendar sebagai pengatur jadwal</p>
                </div>
            </div>
            
            {{-- CONTENT --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 md:mt-12">
                {{-- LEFT CONTENT --}}
                <div class="bg-[#FAFAFA] p-4 md:p-6 rounded-xl h-fit max-h-[560px] overflow-y-auto">
                    <h2 class="font-bold text-base sm:text-lg md:text-xl text-[#155458]">Agenda anda</h2>   
                    @if ($bookings && $bookings->isNotEmpty())
                        @foreach ($bookings as $book)
                        @php
                            $statusClass = '';
                            $statusBgColor = '';
                            $statusIcon = '';
                
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
                        <div class="text-[#4F4F4F] py-4 border-b last:border-b-0">
                            <p class="font-semibold text-sm sm:text-base md:text-lg">{{ $book->pasien->name }}</p>
                            <p class="text-xs sm:text-sm md:text-base mt-1">{{ \Carbon\Carbon::parse($book->jadwal->waktu)->isoFormat('dddd, D MMMM YYYY') }}</p>
                            <p class="text-xs sm:text-sm md:text-base">
                                {{ \Carbon\Carbon::parse($book->jadwal->waktu)->addHours(7)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($book->jadwal->waktu)->addHours(8)->format('H:i') }} WIB
                            </p>
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-2 gap-2">
                                <p class="flex items-center gap-2 {{ $statusClass }} text-xs sm:text-sm">
                                    <img alt="infoLogo" class="h-4 w-4" src="{{ $statusIcon }}">
                                    {{ $statusInfo }}
                                </p>
                                <span class="text-xs sm:text-sm text-[#FAFAFA] px-3 py-1 {{ $statusBgColor }} rounded-full">{{ $book->status }}</span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-gray-700 text-sm mt-4">Tidak ada agenda</p>
                    @endif
                </div>
                
                {{-- RIGHT CONTENT : JADWAL --}}
                <div class="md:col-span-2 bg-[#FAFAFA] h-fit p-4 md:p-6 rounded-xl">
                    <div class="text-center mb-4">
                        <h2 class="font-bold text-base sm:text-lg md:text-xl text-[#4F4F4F]">SIKOLOV WEEK AGENDA</h2>
                    </div>
                    <div class="h-[500px] md:h-[470px] w-full">
                        <iframe 
                            src="https://calendar.google.com/calendar/embed?src=svmentalhealthacc%40gmail.com&ctz=Asia%2FJakarta" 
                            style="border: 0;"
                            class="w-full h-full"
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
            const messages = document.querySelectorAll('#flash-message-container > div');
            
            messages.forEach(function(message) {
                setTimeout(() => {
                    message.classList.add('opacity-0', 'transform', 'translate-y-[-100%]');
                }, 5000);

                setTimeout(() => {
                    message.remove();
                }, 5500);
            });
        });
    </script>
</body>
</html>