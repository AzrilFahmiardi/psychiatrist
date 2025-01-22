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
    <div>
    </div>
    <div class="bg-[##FAFAFA] font-poppins px-10">
        <div class="min-h-screen w-full flex flex-col items-center">
            {{-- NAVBAR --}}
@if (Auth::check())
<nav class="w-full pt-7 pb-5 font-poppins text-[#155458] text-xl md:px-20 px-6 relative">
    <div class="flex justify-between items-center">
        {{-- <a href="/" class="font-bold">SV UGM</a> --}}
        <div class="bg-[#155458] p-2 rounded-xl">
            <img src="{{ asset('images/logo_sikolov_2.png') }}" alt="logo sikolov" class="w-[150px]">

        </div>

        
        <!-- Hamburger Button -->
        <button type="button" onclick="toggleMenu()" class="md:hidden z-50 relative w-8 h-8 flex justify-center items-center">
            <div id="hamburger" class="flex flex-col justify-between w-6 h-5 transform transition-all duration-300">
                <span class="w-full h-0.5 bg-[#155458] transform transition-all duration-300"></span>
                <span class="w-full h-0.5 bg-[#155458] transform transition-all duration-300"></span>
                <span class="w-full h-0.5 bg-[#155458] transform transition-all duration-300"></span>
            </div>
        </button>

        <div class="hidden md:flex md:items-center md:gap-7">
            <a href="/">Home</a>
            <a href="{{ route('riwayat.booking') }}" class="font-bold">Riwayat</a>
        </div>

        <a href="{{ route('pasien.profile') }}" class="hidden md:block font-bold bg-transparent border-2 border-[#155458be] hover:bg-[#15545870] px-4 py-1 rounded-md">
            {{ Auth::user()->name }}
        </a>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="absolute top-full left-0 w-full bg-white border-2 border-[#155458] rounded-xl transform transition-all duration-300 -translate-y-full opacity-0 invisible md:hidden shadow-lg z-30">
        <div class="py-4 px-6 space-y-4">
            <a href="/" class="block hover:text-gray-600 transition-colors">Home</a>
            <a href="{{ route('riwayat.booking') }}" class="block font-bold hover:text-gray-600 transition-colors">Riwayat</a>
            <a href="{{ route('pasien.profile') }}" class="block font-bold bg-[#155458] text-white px-4 py-2 rounded-md hover:bg-[#15545870] w-fit">
                {{ Auth::user()->name }}
            </a>
        </div>
    </div>
</nav>
@else
<nav class="w-full pt-7 pb-5 font-poppins text-[#155458] text-xl md:px-20 px-6 relative">
    <div class="flex justify-between items-center">
        <a href="/" class="font-bold">SV UGM</a>
        
        <!-- Hamburger Button -->
        <button type="button" onclick="toggleMenu()" class="md:hidden z-50 relative w-8 h-8 flex justify-center items-center">
            <div id="hamburger" class="flex flex-col justify-between w-6 h-5 transform transition-all duration-300">
                <span class="w-full h-0.5 bg-[#155458] transform transition-all duration-300"></span>
                <span class="w-full h-0.5 bg-[#155458] transform transition-all duration-300"></span>
                <span class="w-full h-0.5 bg-[#155458] transform transition-all duration-300"></span>
            </div>
        </button>

        <div class="hidden md:flex md:items-center md:gap-7">
            <a href="/" class="font-bold">Home</a>
            <a href="#" onclick="showLoginModal(event)" class="font-bold">Riwayat</a>
        </div>

        <a href="/login" class="hidden md:block font-bold bg-[#155458] text-white px-4 py-1 rounded-md">Login</a>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="absolute top-full left-0 w-full bg-white border-2 border-[#155458] rounded-xl transform transition-all duration-300 -translate-y-full opacity-0 invisible md:hidden shadow-lg z-30">
        <div class="py-4 px-6 space-y-4">
            <a href="/" class="block font-bold hover:text-gray-600 transition-colors">Home</a>
            <a href="#" onclick="showLoginModal(event)" class="block font-bold hover:text-gray-600 transition-colors">Riwayat</a>
            <a href="/login" class="block font-bold bg-[#155458] text-white px-4 py-2 rounded-md hover:bg-[#15545870] w-fit">
                Login
            </a>
        </div>
    </div>
</nav>

<!-- Modal (unchanged) -->
<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-md text-center">
        <p class="text-lg">Silakan login untuk melihat riwayat</p>
        <div class="mt-4">
            <a href="/login" class="bg-[#155458] px-4 py-2 rounded-md text-white">Login</a>
            <button onclick="closePopup()" class="bg-gray-500 px-4 py-2 rounded-md text-white ml-2">Tutup</button>
        </div>
    </div>
</div>
@endif
<hr class="bg-[#00000080] h-[2px] w-full px-20">
{{-- END NAVBAR --}}

            <h1 class="mt-10 text-[1rem] sm:text-[1.5rem]  md:text-[2rem] font-bold text-[#155458]">Riwayat  dan hasil konseling pasien</h1>
            
            {{-- GOOGLE CALENDAR --}}
            <div class="card-body w-[90vw] h-[500px] my-5 rounded-xl">
                <iframe src="https://calendar.google.com/calendar/embed?src={{ urlencode(auth()->user()->email) }}" 
                        style="border: 0" 
                        width="100%" 
                        height="600" 
                        frameborder="0" 
                        scrolling="no">
                </iframe>
            </div>
            
            <div class="w-full px-0 lg:px-20 mt-[100px]">
                <p class="font-bold text-gray-800 my-5 text-xs sm:text-sm  md:text-base">status</p>
                <table class="text-[0.6rem] sm:text-[0.8rem] md:text-sm">
                    <tbody class="divide-y-8 divide-transparent">
                        <tr>
                            <td class="w-8">
                                <div class="w-4 h-4 rounded-full bg-yellow-600"></div>
                            </td>
                            <td class="text-gray-1000">scheduled</td>
                            <td class="px-2">:</td>
                            <td class="text-gray-700">menunggu konfirmasi admin terkait bukti pembayaran</td>
                        </tr>
                        <tr>
                            <td class="w-8">
                                <div class="w-4 h-4 rounded-full bg-green-700"></div>
                            </td>
                            <td class="text-gray-1000">submitted</td>
                            <td class="px-2">:</td>
                            <td class="text-gray-700">siap untuk pertemuan</td>
                        </tr>
                        <tr>
                            <td class="w-8">
                                <div class="w-4 h-4 rounded-full bg-[#155458]"></div>
                            </td>
                            <td class="text-gray-1000">completed</td>
                            <td class="px-2">:</td>
                            <td class="text-gray-700">konseling selesai dengan hasil konsultasi</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            
            <div class="w-full md:px-10 py-16 mt-[10px]">
                
                <div class=" h-[250px]">
                    <p class=" text-[#155458] text-xs sm:text-sm  md:text-base font-bold">Jadwal yang dibooking</p>
                    
                    <div class="gap-5 mt-5 flex h-[180px] overflow-auto">
                        @foreach ($bookings as $book)
                            <div class="min-w-[200px] sm:min-w-[300px] md:min-w-[500px] h-fit border border-gray-200 shadow-lg rounded-xl py-5 px-5">
                                <p class="font-bold text-[0.8rem] sm:text-[1rem]  md:text-[1.3rem]">{{ $book->psikolog->name }}</p>
                                <p class="text-gray-700 text-xs sm:text-sm  md:text-base">{{ \Carbon\Carbon::parse($book->jadwal->waktu)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                <p class="text-gray-700 text-xs sm:text-sm  md:text-base">
                                    {{ 
                                        \Carbon\Carbon::parse($book->jadwal->waktu)->addHours(7)->format('H:i') . '-' . 
                                        \Carbon\Carbon::parse($book->jadwal->waktu)->addHours(8)->format('H:i') . ' WIB' 
                                    }}
                                </p>
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-3">
                                    <p class="text-gray-700 mt-3 md:mt-8 text-xs sm:text-sm  md:text-base">status: 
                                        <span class="px-2 text-xs sm:text-sm  md:text-base
                                            @if($book->status === 'completed')
                                                bg-[#155458]
                                            @elseif($book->status === 'submitted')
                                                bg-green-700
                                            @elseif($book->status === 'scheduled')
                                                bg-yellow-600
                                            @endif
                                            p-1 text-white rounded-md ml-1">
                                            {{ $book->status }}
                                        </span>
                                    </p>
                    
                                    <div class="flex items-center gap-4">
                                        @if($book->status === 'completed')
                                            <p class="text-[#155458] text-[0.4rem] sm:text-[0.6rem]  md:text-[0.8rem] flex items-center gap-2 cursor-pointer hover:underline"
                                            onclick="showConsultationResult('{{ $book->psikolog->name }}', '{{ \Carbon\Carbon::parse($book->jadwal->waktu)->isoFormat('dddd, D MMMM YYYY') }}', '{{ $book->konsultasi->hasil_konsultasi }}')">
                                                Lihat hasil konsultasi
                                                <span><img src="../images/right_arrow.png" alt="tes"></span>
                                            </p>
                                        @elseif($book->status !== 'completed')
                                            <form action="{{ route('booking.cancel', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                @csrf
                                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 text-sm">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                    </div>
                    
                </div>
                
            </div>

            

        </div>
        <!-- Modal untuk Hasil Konsultasi -->
        <div id="consultationModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-white w-[90vw] max-w-[600px] p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold text-[#155458]" id="consultationDoctor"></h2>
                <p class="text-gray-700 mt-2" id="consultationDate"></p>
                <hr class="my-4">
                <p class="text-gray-600" id="consultationResult"></p>
                <div class="flex justify-end mt-6">
                    <button 
                        onclick="closeConsultationModal()" 
                        class="bg-[#155458] text-white px-4 py-2 rounded-md hover:bg-[#0f3d3d]"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- JavaScript untuk Modal -->
        <script>
            function showConsultationResult(doctor, date, result) {
                // Set data ke modal
                document.getElementById('consultationDoctor').textContent = doctor;
                document.getElementById('consultationDate').textContent = date;
                document.getElementById('consultationResult').textContent = result;
                // Tampilkan modal
                document.getElementById('consultationModal').classList.remove('hidden');
            }

            function closeConsultationModal() {
                // Sembunyikan modal
                document.getElementById('consultationModal').classList.add('hidden');
            }
        </script>
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
          
<script>
    function toggleMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        const hamburger = document.getElementById('hamburger');
        const spans = hamburger.getElementsByTagName('span');
    
        if (mobileMenu.classList.contains('-translate-y-full')) {
            // Menu Opening
            mobileMenu.classList.remove('-translate-y-full', 'opacity-0', 'invisible');
            mobileMenu.classList.add('translate-y-0', 'opacity-100', 'visible');
            
            // Hamburger Animation
            spans[0].classList.add('rotate-45', 'translate-y-2');
            spans[1].classList.add('opacity-0');
            spans[2].classList.add('-rotate-45', '-translate-y-2');
        } else {
            // Menu Closing
            mobileMenu.classList.remove('translate-y-0', 'opacity-100', 'visible');
            mobileMenu.classList.add('-translate-y-full', 'opacity-0', 'invisible');
            
            // Hamburger Animation
            spans[0].classList.remove('rotate-45', 'translate-y-2');
            spans[1].classList.remove('opacity-0');
            spans[2].classList.remove('-rotate-45', '-translate-y-2');
        }
    }
    </script>
    </div>


</body>
</html>