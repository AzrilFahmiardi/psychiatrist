@if (Auth::check())
    <nav class="flex justify-between w-full py-7 font-poppins text-[#FAFAFA] text-xl px-20">
        <a href="/" class="text-shadow-lg font-bold">SV UGM</a>
        <div class="flex gap-7">
            <a href="/" class="font-bold">Home</a>
            <a href="{{ route('riwayat.booking') }}">Riwayat</a>
        </div>
        <a href="{{ route('pasien.profile') }}" class="font-bold bg-[#155458be] px-4 py-1 rounded-md hover:bg-[#1554588e]">{{ Auth::user()->name }}</a>
    </nav>
@else
    <nav class="flex justify-between w-full py-7 font-poppins text-[#FAFAFA] text-xl px-20">
        <a href="/" class="text-shadow-lg font-bold">SV UGM</a>
        <div class="flex gap-7">
            <a href="/" class="font-bold">Home</a>
            <a href="#" onclick="showLoginModal(event)">Riwayat</a> <!-- Trigger modal -->
        </div>
        <a href="/login" class="font-bold bg-[#155458] px-4 py-1 rounded-md">Login</a>
    </nav>
    
    <!-- Modal -->
    <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-md text-center">
            <p class="text-lg">Silakan login untuk melihat riwayat</p>
            <div class="mt-4">
                <a href="/login" class="bg-[#155458] px-4 py-2 rounded-md text-white">Login</a>
                <button onclick="closePopup()" class="bg-gray-500 px-4 py-2 rounded-md text-white ml-2">Tutup</button>
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
