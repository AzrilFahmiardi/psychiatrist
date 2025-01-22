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
            <a href="{{ route('home.psikolog') }}">Home</a>
            <a href="{{ route('agenda.psikolog') }}" class="font-bold">Agenda</a>
        </div>

        <a href="{{ route('nonPasien.logout') }}" class="hidden md:block font-bold bg-transparent border-2 border-[#155458be] hover:bg-[#15545870] px-4 py-1 rounded-md">
            {{ Auth::user()->name }}
        </a>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="absolute top-full left-0 w-full bg-white border-2 border-[#155458] rounded-xl transform transition-all duration-300 -translate-y-full opacity-0 invisible md:hidden shadow-lg z-30">
        <div class="py-4 px-6 space-y-4">
            <a href="{{ route('home.psikolog') }}" class="block hover:text-gray-600 transition-colors">Home</a>
            <a href="{{ route('agenda.psikolog') }}" class="block font-bold hover:text-gray-600 transition-colors">Agenda</a>
            <a href="{{ route('nonPasien.logout') }}" class="block font-bold bg-[#155458] text-white px-4 py-2 rounded-md hover:bg-[#15545870] w-fit">
                {{ Auth::user()->name }}
            </a>
        </div>
    </div>
</nav>

@endif
<hr class="bg-[#00000080] h-[2px] w-full px-20">
{{-- END NAVBAR --}}
            
{{-- KONTEN --}}
<div class="w-full py-16">
<div class="">
    <p class="text-[#155458] text-[1.2rem] sm:text-[1.7rem]  md:text-[2rem] mx-auto font-bold w-fit py-2 px-6 rounded-xl">Jadwal minggu ini</p>
                    
<div class="col-span-2 py-3 px-5 rounded-xl w-[90%] md:w-4/5 overflow-auto mx-auto">
    {{-- GRID 7 HARI --}}
    <div class="grid grid-cols-7 gap-3 min-w-[1200px]">
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
                            :time="'' . Carbon::parse($jad->waktu)->setTimezone('Asia/Jakarta')->format('H:i') . '-' . Carbon::parse($jad->waktu)->setTimezone('Asia/Jakarta')->addHour()->format('H:i') . ' WIB'"
                            :status="$jad->status"
                        />
                    @endforeach
                @else
                    <x-agendaCard 
                        :name="'-'"
                        :time="'' . Carbon::parse($jad->waktu)->setTimezone('Asia/Jakarta')->format('H:i') . '-' . Carbon::parse($jad->waktu)->setTimezone('Asia/Jakarta')->addHour()->format('H:i') . ' WIB'"
                        :status="$jad->status"
                    />
                @endif
            @endforeach
        @else
            <!-- Tidak ada jadwal -->
            <p class="text-gray-600 text-[0.5rem] lg:text-sm flex-grow rounded-lg bg-gray-200 flex items-center justify-center">
                No schedules available
            </p>
        @endif
    </div>
    
        @endforeach
    </div>
    
</div>
<div class="flex justify-center md:justify-end gap-5 items-center mt-5  w-[90%] md:w-4/5 mx-auto">
    <form action="{{ route('agenda.psikolog.filter') }}" method="GET" class="flex gap-x-3">
        <input type="hidden" name="week_offset" value="{{ intval(request('week_offset', 0)) - 1 }}">
        <button type="submit" class="font-bold text-white bg-[#155458] hover:bg-[#155458c2] px-3 py-2 rounded-full">
            ←
        </button>
        
    </form>

    <form action="{{ route('agenda.psikolog.filter') }}" method="GET" class="flex gap-x-3">
        <input type="hidden" name="week_offset" value="0">
        <button type="submit" class="font-bold text-[#155458] border border-[#155458]  px-4 py-2 rounded-md text-xs sm:text-sm  md:text-base">
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
    <div class="mt-10 flex flex-col gap-20">
        <div>
            {{-- AGENDA YANG AKAN DATANG --}}
            <p class=" text-[#155458] text-base sm:text-lg font-bold mb-2">AGENDA ANDA</p>
            <div class="flex  gap-5  overflow-x-auto py-10">
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
                <div class="text-[#4F4F4F] md:min-w-[400px] py-5 px-5 border-2 border-[#155458] rounded-lg hover:bg-gray-100">
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
                            <button 
                                class="consultation-btn text-[#155458] border border-[#155458] hover:bg-[#15545828] rounded px-2"
                                data-booking-id="{{ $book->id }}"
                                data-patient-name="{{ $book->pasien->name }}"
                                data-date="{{ \Carbon\Carbon::parse($book->jadwal->waktu)->isoFormat('dddd, D MMMM YYYY') }}"
                                data-time="{{ \Carbon\Carbon::parse($book->jadwal->waktu)->addHours(7)->format('H:i') }} - {{ \Carbon\Carbon::parse($book->jadwal->waktu)->addHours(8)->format('H:i') }} WIB"
                            >
                                + hasil konsultasi
                            </button>                     
                            @endif
                            
                            <p class="text-[0.9rem] text-[#FAFAFA] px-2 py-1 {{ $statusBgColor }} rounded">{{ $book->status }}</p>
                        </div>
                    </div>
                    
                </div>
                
                
               
                
                @endforeach
            @else
                <p  class="text-gray-700 text-xs sm:text-sm">tidak ada agenda</p>
            @endif
            </div>
        </div>
        <div>
            {{-- RIWAYAT KONSELING --}}
            <p class=" text-[#155458] text-base sm:text-lg font-bold mb-2">RIWAYAT KONSELING</p>
            <div class="flex gap-5 overflow-x-auto">
                @if ($completes && $completes->isNotEmpty())
                    @foreach ($completes as $kons)
                    <div class="flex  flex-col text-[#4F4F4F] py-5 px-5 border-2 border-[#155458] rounded-lg hover:bg-gray-100 min-w-[200px] md:min-w-[400px] h-[250px] max-h-[300px]">
                        <p class="font-semibold text-[1.1rem]">{{ $kons->pasien->name }}</p>
                        <p class="text-[0.7rem] sm:text-[0.8rem]  md:text-[0.9rem]">{{ \Carbon\Carbon::parse($kons->jadwal->waktu)->isoFormat('dddd, D MMMM YYYY') }}</p>
                        <div class="flex lg:flex-row flex-col gap-2 justify-between">
                            <p class="text-[0.7rem] sm:text-[0.8rem]  md:text-[0.9rem]">
                                {{ \Carbon\Carbon::parse($kons->jadwal->waktu)->addHours(7)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($kons->jadwal->waktu)->addHours(8)->format('H:i') }} WIB
                            </p>
                            <button 
                                class="consultation-btn text-[#155458] border border-[#155458] text-sm  md:text-base hover:bg-[#15545828] rounded py-2 md:py-0 px-2"
                                data-konsultasi-id="{{ $kons->konsultasi->id }}"
                                data-patient-name="{{ $kons->pasien->name }}"
                                data-date="{{ \Carbon\Carbon::parse($kons->jadwal->waktu)->isoFormat('dddd, D MMMM YYYY') }}"
                                data-time="{{ \Carbon\Carbon::parse($kons->jadwal->waktu)->addHours(7)->format('H:i') }} - {{ \Carbon\Carbon::parse($kons->jadwal->waktu)->addHours(8)->format('H:i') }} WIB"
                                data-hasil-konsultasi="{{ $kons->konsultasi->hasil_konsultasi }}"
                            >
                                edit hasil konsultasi
                            </button>                    
                                                    
                        </div>
                        <p class="w-full flex-grow bg-gray-200 text-gray-900 text-sm rounded mt-4 p-2 break-words overflow-auto">
                            {{ $kons->konsultasi->hasil_konsultasi }}
                        </p>                     
                    </div>
                    @endforeach
                @else
                    <p class="text-gray-700 text-sm">tidak ada riwayat konseling</p>
                @endif
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
</div>


{{-- MODAL --}}
<div id="addConsultationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg w-full max-w-2xl">
        <div class="p-4 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-[#155458]">Tambah Hasil Konsultasi</h3>
                <button onclick="closeAddModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-4 font-poppins">
            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                <p class="font-semibold text-lg add-patient-name text-gray-800"></p>
                <p class="text-sm add-consultation-date text-gray-700"></p>
                <p class="text-sm add-consultation-time text-gray-700"></p>
            </div>

            <form id="addConsultationForm" method="POST" action="{{ route('add.konsultasi') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="booking_id" id="addBookingId">
                <div>
                    <textarea 
                        name="hasil_konsultasi" 
                        id="add_hasil_konsultasi" 
                        rows="6" 
                        class="w-full rounded-lg border border-gray-500 p-3 text-gray-800 focus:border-[#155458] focus:ring focus:ring-[#15545833]"
                        required
                    ></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button 
                        type="button" 
                        onclick="closeAddModal()"
                        class="px-4 py-2 text-[#155458] border border-[#155458] rounded-lg hover:bg-gray-50"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-[#155458] text-white rounded-lg hover:bg-[#155458dd]"
                    >
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT CONSULTATION MODAL --}}
<div id="editConsultationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg w-full max-w-2xl">
        <div class="p-4 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-[#155458]">Edit Hasil Konsultasi</h3>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-4 font-poppins">
            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                <p class="font-semibold text-lg edit-patient-name text-gray-800"></p>
                <p class="text-sm edit-consultation-date text-gray-700"></p>
                <p class="text-sm edit-consultation-time text-gray-700"></p>
            </div>

            <form id="editConsultationForm" method="POST" action="{{ route('update.konsultasi') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="konsultasi_id" id="editKonsultasiId">
                <div>
                    <textarea 
                        name="hasil_konsultasi" 
                        id="edit_hasil_konsultasi" 
                        rows="6" 
                        class="w-full rounded-lg border border-gray-500 p-3 text-gray-800 focus:border-[#155458] focus:ring focus:ring-[#15545833]"
                        required
                    ></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button 
                        type="button" 
                        onclick="closeEditModal()"
                        class="px-4 py-2 text-[#155458] border border-[#155458] rounded-lg hover:bg-gray-50"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-[#155458] text-white rounded-lg hover:bg-[#155458dd]"
                    >
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Functions for Add Consultation Modal
    function openAddModal(data) {
        const modal = document.getElementById('addConsultationModal');
        const bookingId = document.getElementById('addBookingId');
        const patientName = document.querySelector('.add-patient-name');
        const consultationDate = document.querySelector('.add-consultation-date');
        const consultationTime = document.querySelector('.add-consultation-time');
        
        bookingId.value = data.id;
        patientName.textContent = data.patient_name;
        consultationDate.textContent = data.date;
        consultationTime.textContent = data.time;
        
        modal.classList.remove('hidden');
    }

    function closeAddModal() {
        const modal = document.getElementById('addConsultationModal');
        modal.classList.add('hidden');
        document.getElementById('addConsultationForm').reset();
    }

    // Functions for Edit Consultation Modal
    function openEditModal(data) {
        const modal = document.getElementById('editConsultationModal');
        const konsultasiId = document.getElementById('editKonsultasiId');
        const hasilKonsultasi = document.getElementById('edit_hasil_konsultasi');
        const patientName = document.querySelector('.edit-patient-name');
        const consultationDate = document.querySelector('.edit-consultation-date');
        const consultationTime = document.querySelector('.edit-consultation-time');
        
        konsultasiId.value = data.id;
        hasilKonsultasi.value = data.hasil_konsultasi;
        patientName.textContent = data.patient_name;
        consultationDate.textContent = data.date;
        consultationTime.textContent = data.time;
        
        modal.classList.remove('hidden');
    }

    function closeEditModal() {
        const modal = document.getElementById('editConsultationModal');
        modal.classList.add('hidden');
        document.getElementById('editConsultationForm').reset();
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Add consultation button listeners
        document.querySelectorAll('button[data-booking-id]').forEach(button => {
            button.addEventListener('click', () => {
                const data = {
                    id: button.dataset.bookingId,
                    patient_name: button.dataset.patientName,
                    date: button.dataset.date,
                    time: button.dataset.time
                };
                openAddModal(data);
            });
        });

        // Edit consultation button listeners
        document.querySelectorAll('button[data-konsultasi-id]').forEach(button => {
            button.addEventListener('click', () => {
                const data = {
                    id: button.dataset.konsultasiId,
                    patient_name: button.dataset.patientName,
                    date: button.dataset.date,
                    time: button.dataset.time,
                    hasil_konsultasi: button.dataset.hasilKonsultasi
                };
                openEditModal(data);
            });
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
</body>
</html>