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
                        <a href="{{ route('home.psikolog') }}" >Home</a>
                        <a href="{{ route('agenda.psikolog') }}" class="font-bold">Agenda</a>
                    </div>
                    <a href="{{ route('pasien.profile') }}" class="font-bold bg-transparent border-2 border-[#155458be] hover:bg-[#15545870] px-4 py-1 rounded-md">{{ Auth::user()->name }}</a>
                </nav>

            @endif
            <hr class="bg-[#00000080] h-[2px] w-full px-20">

            {{-- END NAVBAR --}}
            
            {{-- KONTEN --}}
            <div class="w-full px-20 py-16">
                <div class="">
                    <p class="text-[#155458] text-[2rem] mx-auto font-bold w-fit py-2 px-6 rounded-xl">Jadwal minggu ini</p>
                    
<div class="col-span-2 py-3 px-5 rounded-xl">
    {{-- GRID 7 HARI --}}
    <div class="grid grid-cols-7 gap-3">
        @php
            use Carbon\Carbon;
            
            // Convert week_offset to integer
            $weekOffset = intval(request('week_offset', 0));
            
            // Get the start of current week (Monday)
            $startDate = Carbon::now('Asia/Jakarta')
                ->startOfWeek()
                ->addWeeks($weekOffset);
        @endphp
    
        @foreach (range(0, 6) as $dayOffset) 
        @php
            \Carbon\Carbon::setLocale('id');
            $currentDay = $startDate->copy()->addDays($dayOffset);
            $jadwalsForDay = $jadwals->filter(function ($jadwal) use ($currentDay) {
                return Carbon::parse($jadwal->waktu)->isSameDay($currentDay);
            });
        @endphp
    
    <div class="day-schedule  flex flex-col min-h-[450px]">
        <p class="text-[1.2rem] font-bold text-[#4F4F4F]">{{ $currentDay->translatedFormat('l') }}</p>
        <p class="text-[0.7rem] mb-3">{{ $currentDay->translatedFormat('d F Y') }}</p>
        @if ($jadwalsForDay->isNotEmpty())
            <!-- Jadwal tersedia -->
            @foreach ($jadwalsForDay as $jad)
                @if ($jad->pasien->isNotEmpty())
                    @foreach ($jad->pasien as $pasien)
                        <x-agendaCard 
                            :name="$pasien->name"
                            :time="(Carbon::parse($jad->waktu)->setTimezone('Asia/Jakarta')->format('H:i') . ' WIB')"
                            :status="$jad->status"
                        />
                    @endforeach
                @else
                    <x-agendaCard 
                        :name="'-'"
                        :time="(Carbon::parse($jad->waktu)->setTimezone('Asia/Jakarta')->format('H:i') . ' WIB')"
                        :status="$jad->status"
                    />
                @endif
            @endforeach
        @else
            <!-- Tidak ada jadwal -->
            <p class="text-gray-600 text-sm flex-grow rounded-lg bg-gray-200 flex items-center justify-center">
                No schedules available
            </p>
        @endif
    </div>
    
        @endforeach
    </div>
    <div class="flex justify-end gap-5 items-center mt-5">
        <form action="{{ route('agenda.psikolog.filter') }}" method="GET" class="flex gap-x-3">
            <input type="hidden" name="week_offset" value="{{ intval(request('week_offset', 0)) - 1 }}">
            <button type="submit" class="font-bold text-white bg-[#155458] hover:bg-[#155458c2] px-3 py-2 rounded-full">
                ←
            </button>
            
        </form>

        <form action="{{ route('agenda.psikolog.filter') }}" method="GET" class="flex gap-x-3">
            <input type="hidden" name="week_offset" value="0">
            <button type="submit" class="font-bold text-[#155458] border border-[#155458]  px-4 py-2 rounded-md">
                Minggu Ini
            </button>
        </form>

        <form action="{{ route('agenda.psikolog.filter') }}" method="GET" class="flex gap-x-3">
            <input type="hidden" name="week_offset" value="{{ intval(request('week_offset', 0)) + 1 }}">
            <button type="submit" class="font-bold text-white bg-[#155458] hover:bg-[#155458c2] px-3 py-2 rounded-full">
                →
            </button>
        </form>
    </div>
</div>
                    
</div>
    <div class="mt-10">
        <p class=" text-[#155458] text-lg font-bold mb-2">Agenda yang akan datang</p>
        
        <div class="grid grid-cols-3 gap-5">
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
            <div class="text-[#4F4F4F] py-5 px-5 border-2 border-[#155458] rounded-lg hover:bg-gray-100">
                <p class="font-semibold text-[1.1rem]">{{ $book->pasien->name }}</p>
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
                    <div class="flex gap-2">
                        @if (now()->greaterThan($book->jadwal->waktu))
                            <button class="text-[#155458] border border-[#155458] hover:bg-[#15545828] rounded px-2">+ hasil konsultasi</button>
                        @endif
                        
                        <p class="text-[0.9rem] text-[#FAFAFA] px-2 py-1 {{ $statusBgColor }} rounded">{{ $book->status }}</p>
                    </div>
                </div>
                
            </div>
            @endforeach
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
</div>


</body>
</html>