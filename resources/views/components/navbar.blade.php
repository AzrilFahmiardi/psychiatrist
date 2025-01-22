@if (Auth::check())
    <nav class="w-full py-7 font-poppins text-[#FAFAFA] text-xl md:px-20 relative z-30">
        <div class="flex justify-between items-center z-30">
            {{-- <a href="/" class="text-shadow-lg font-bold z-50">SV UGM</a> --}}
            <img src="{{ asset('images/logo_sikolov_2.png') }}" alt="logo sikolov" class="w-[150px]">

            
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
                <a href="{{ route('riwayat.booking') }}">Riwayat</a>
            </div>

            <a href="{{ route('pasien.profile') }}" class="hidden md:block font-bold bg-[#155458be] px-4 py-1 rounded-md hover:bg-[#1554588e]">
                {{ Auth::user()->name }}
            </a>
        </div>

        <!-- Mobile Menu yang Lebih Compact -->
        <div id="mobileMenu" class="absolute top-full left-0 w-full bg-[#155458] rounded-xl transform transition-all duration-300 -translate-y-full opacity-0 invisible md:hidden shadow-lg z-30">
            <div class="py-4 px-6 space-y-4">
                <a href="/" class="block font-bold hover:text-gray-300 transition-colors">Home</a>
                <a href="{{ route('riwayat.booking') }}" class="block hover:text-gray-300 transition-colors">Riwayat</a>
                <a href="{{ route('pasien.profile') }}" class="block font-bold bg-white text-[#155458] px-4 py-2 rounded-md hover:bg-gray-100 w-fit">
                    {{ Auth::user()->name }}
                </a>
            </div>
        </div>
    </nav>
@else
    <nav class="w-full py-7 font-poppins text-[#FAFAFA] text-xl md:px-20 relative">
        <div class="flex justify-between items-center">
            {{-- <a href="/" class="text-shadow-lg font-bold z-50">SV UGM</a> --}}
            <img src="{{ asset('images/logo_sikolov_2.png') }}" alt="logo sikolov" class="w-[150px]">

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

            <a href="/login" class="hidden md:block font-bold bg-[#155458] px-4 py-1 rounded-md">Login</a>
        </div>

        <!-- Mobile Menu yang Lebih Compact -->
        <div id="mobileMenu" class="absolute top-full left-0 w-full bg-[#155458] rounded-xl transform transition-all duration-300 -translate-y-full opacity-0 invisible md:hidden shadow-lg z-30">
            <div class="py-4 px-6 space-y-4">
                <a href="/" class="block font-bold hover:text-gray-300 transition-colors">Home</a>
                <a href="#" onclick="showLoginModal(event)" class="block hover:text-gray-300 transition-colors">Riwayat</a>
                <a href="/login" class="block font-bold bg-white text-[#155458] px-4 py-2 rounded-md hover:bg-gray-100 w-fit">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Modal tidak berubah -->
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

    function showLoginModal(event) {
        event.preventDefault();
        document.getElementById('loginModal').classList.remove('hidden');
    }

    function closePopup() {
        document.getElementById('loginModal').classList.add('hidden');
    }
</script>