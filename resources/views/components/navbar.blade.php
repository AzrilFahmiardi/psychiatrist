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
