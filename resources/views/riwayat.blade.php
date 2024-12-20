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
                <nav class="flex justify-between w-full pt-7 pb-5 font-poppins text-[#155458] text-xl px-20">
                    <a href="/" class=" font-bold">SV UGM</a>
                    <div class="flex gap-7">
                        <a href="/" >Home</a>
                        <a href="{{ route('riwayat.booking') }}" class="font-bold">Riwayat</a>
                    </div>
                    <a href="{{ route('pasien.profile') }}" class="font-bold bg-transparent border-2 border-[#155458be] hover:bg-[#15545870] px-4 py-1 rounded-md">{{ Auth::user()->name }}</a>
                </nav>
            @else
                <nav class="flex justify-between w-full pt-7 pb-5 font-poppins text-[#155458] text-xl px-20">
                    <a href="/" class=" font-bold">SV UGM</a>
                    <div class="flex gap-7">
                        <a href="/" class="font-bold">Home</a>
                        <a href="#" onclick="showLoginModal(event)" class="font-bold">Riwayat</a> <!-- Trigger modal -->
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
            <hr class="bg-[#00000080] h-[2px] w-full px-20">

            {{-- END NAVBAR --}}
            <h1 class="mt-10 text-[2rem] font-bold text-[#155458]">Riwayat  dan hasil konseling pasien</h1>
            
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
            
            
            
            <div class="w-full px-20 py-16 mt-16">
                <div class=" h-fit ">
                    <p class="bg-[#155458] text-[#FAFAFA] w-fit py-2 px-6 rounded-xl">Jadwal yang dibooking</p>
                    
                    <div class="gap-5 mt-10 grid grid-cols-2">
                        @foreach ($bookings as $book)
                            <div class="w-full h-fit border border-gray-200 shadow-lg rounded-xl py-5 px-5">
                                <p class="font-bold text-[1.3rem]">{{ $book->psikolog->name }}</p>
                                <p class="text-gray-700">{{ \Carbon\Carbon::parse($book->jadwal->waktu)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                <p class="text-gray-700">
                                    {{ 
                                        \Carbon\Carbon::parse($book->jadwal->waktu)->addHours(7)->format('H:i') . '-' . 
                                        \Carbon\Carbon::parse($book->jadwal->waktu)->addHours(8)->format('H:i') . ' WIB' 
                                    }}
                                </p>
                                <div class="flex justify-between items-end">
                                    <p class="text-gray-700 mt-8">status: 
                                        <span class="px-2
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
                                            <p class="text-[#155458] text-[0.8rem] flex items-center gap-2 cursor-pointer hover:underline"
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
    </div>


</body>
</html>