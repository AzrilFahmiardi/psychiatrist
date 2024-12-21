@extends('form_layout')

@section('konten')
{{-- PROGRESS BAR --}}
<div class="w-[70%] item mx-auto my-6 flex items-center gap-x-5">
    <div class="w-full flex flex-col gap-3">
        <label>Persetujuan</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full flex flex-col gap-3">
        <label>Data diri</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full flex flex-col gap-3">
        <label>Pilih jadwal</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full flex flex-col gap-3">
        <label>Ketentuan & submit</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-[#CDCDCD]" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full flex flex-col gap-3">
        <label>Pembayaran</label>
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-[#CDCDCD]" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>

{{-- KONTEN FORM --}}
<div x-data="{
    activeCard: null,
    selectedScheduleId: null,
    selectedPsychologId: null,
    canProceed: false,

    selectSchedule(scheduleId, psychologId, status, waktu) {
        // Convert both times to Asia/Jakarta timezone for consistent comparison
        const jakartaTimezone = 'Asia/Jakarta';
        const currentDate = new Date().toLocaleString('en-US', { timeZone: jakartaTimezone });
        const scheduleDate = new Date(waktu).toLocaleString('en-US', { timeZone: jakartaTimezone });
        
        const currentDateTime = new Date(currentDate);
        const scheduleDateTime = new Date(scheduleDate);
        
        const isExpired = scheduleDateTime < currentDateTime;
        
        console.log('Schedule Selection:', {
            scheduleId,
            psychologId,
            status,
            waktu,
            isExpired,
            currentDate: currentDateTime.toISOString(),
            scheduleDate: scheduleDateTime.toISOString(),
            jakartaTime: new Date().toLocaleString('en-US', { timeZone: jakartaTimezone })
        });

        this.activeCard = scheduleId;

        if (status === 'available' && !isExpired) {
            this.selectedScheduleId = scheduleId;
            this.selectedPsychologId = psychologId;
            this.canProceed = true;
            console.log('Schedule selected successfully');
        } else {
            this.selectedScheduleId = null;
            this.selectedPsychologId = null;
            this.canProceed = false;
            console.log('Schedule not selectable - Status:', status, 'Expired:', isExpired);
        }
    }
}" class="w-full">
    <h1 class="text-center text-[#155458] text-xl font-bold my-10">Pilih jadwal konseling</h1>
    
    <div class="col-span-2 py-3 px-5 rounded-xl">
        <div class="min-w-[500px] w-[80%] mx-auto">
            <div>
                <form action="{{ route('form.pilih_jadwal.update') }}" method="GET" class="w-full grid grid-cols-5 gap-5 mb-5">
                    @csrf
                    <select 
                        id="psikolog" 
                        name="psikolog" 
                        class="col-span-2 w-full text-xs h-7 border-[1px] border-[#4F4F4F] text-[#4F4F4F] rounded-2xl px-4"
                    >
                        @foreach ($psikologs as $psikolog)
                            <option value="{{ $psikolog->id }}" {{ request('psikolog') == $psikolog->id ? 'selected' : '' }}>
                                {{ $psikolog->name }}
                            </option>
                        @endforeach
                    </select>
    
                    @php
                        $jakartaTz = new DateTimeZone('Asia/Jakarta');
                        $today = \Carbon\Carbon::now($jakartaTz)->format('Y-m-d');
                    @endphp
                    
                    <input 
                        type="date" 
                        id="tanggal" 
                        name="tanggal" 
                        class="col-span-2 w-full text-xs h-7 border-[1px] border-[#4F4F4F] text-[#4F4F4F] rounded-2xl px-4" 
                        value="{{ request('tanggal', $today) }}"
                        min="{{ $today }}"
                    >
                    
                    <button type="submit" class="col-span-1 font-bold text-white bg-[#155458] px-3 py-1 rounded-md">
                        Cari
                    </button>
                </form>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                @if ($jadwals && $jadwals->count() > 0)
                    @foreach ($jadwals as $jad)
                        @if ($jad->psikolog)
                            @php
                                // Ensure consistent timezone handling
                                $jakartaTz = new DateTimeZone('Asia/Jakarta');
                                $scheduleDateTime = \Carbon\Carbon::parse($jad->waktu)->setTimezone($jakartaTz);
                                $currentDateTime = \Carbon\Carbon::now($jakartaTz);
                                $isExpired = $scheduleDateTime->lt($currentDateTime);
                                $isAvailable = $jad->status === 'available' && !$isExpired;
                            @endphp
                            <div 
                                @click="selectSchedule({{ $jad->id }}, {{ $jad->psikolog->id }}, '{{ $jad->status }}', '{{ $scheduleDateTime->toIso8601String() }}')"
                                :class="{
                                    'bg-[#155458] text-white border-[#155458]': activeCard === {{ $jad->id }} && {{ json_encode($isAvailable) }},
                                    'bg-gray-200 text-gray-500 border-gray-300 opacity-60': !{{ json_encode($isAvailable) }}
                                }"
                                class="jadwal-card border-2 w-full py-2 px-2 rounded-md transition duration-300 ease-in-out 
                                    {{ !$isAvailable ? 'cursor-not-allowed' : 'hover:scale-[1.02] cursor-pointer' }}"
                            >
                                <p class="text-[1.1rem] font-bold">{{ $jad->psikolog->name }}</p>
                                <div class="flex justify-between">
                                    <p class="text-[0.8rem]">
                                        {{ $scheduleDateTime->locale('id')->translatedFormat('l') }} - 
                                        Pukul {{ $scheduleDateTime->format('H:i') }} WIB
                                    </p>
                                    @if($jad->status === 'booked')
                                        <p class="text-[0.8rem] text-red-500">Sudah Dibooking</p>
                                    @elseif($isExpired)
                                        <p class="text-[0.8rem] text-red-500">Jadwal Kadaluarsa</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="col-span-2 text-center text-gray-500">
                        Tidak ada jadwal tersedia untuk kriteria yang dipilih
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- TOMBOL --}}
    <div class="absolute w-full flex justify-between px-10 bottom-16">
        <div class="flex h-[1.5rem] items-center gap-4">
            <a href="{{ route('form.data_diri') }}" class="flex items-center gap-4">
                <img src="{{ asset('images/back.png') }}" alt="Back">
                <span class="text-[1.5rem] text-[#155458] font-bold">Back</span>
            </a>
        </div>
        <div class="flex h-[1.5rem] items-center gap-4">
            <template x-if="canProceed">
                <a 
                    :href="'{{ route('form.ketentuan_submit') }}?jadwal_id=' + selectedScheduleId + '&psikolog_id=' + selectedPsychologId"
                    class="flex items-center gap-4"
                >
                    <span class="text-[1.5rem] text-[#155458] font-bold">Next</span>
                    <img src="{{ asset('images/next.png') }}" alt="Next">
                </a>
            </template>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('scheduleSelection', () => ({
            activeCard: null,
            selectedScheduleId: null,
            selectedPsychologId: null,
            canProceed: false,

            selectSchedule(scheduleId, psychologId, status, waktu) {
                const jakartaTimezone = 'Asia/Jakarta';
                const currentDate = new Date().toLocaleString('en-US', { timeZone: jakartaTimezone });
                const scheduleDate = new Date(waktu).toLocaleString('en-US', { timeZone: jakartaTimezone });
                
                const currentDateTime = new Date(currentDate);
                const scheduleDateTime = new Date(scheduleDate);
                
                const isExpired = scheduleDateTime < currentDateTime;

                this.activeCard = scheduleId;
                
                if (status === 'available' && !isExpired) {
                    this.selectedScheduleId = scheduleId;
                    this.selectedPsychologId = psychologId;
                    this.canProceed = true;
                } else {
                    this.selectedScheduleId = null;
                    this.selectedPsychologId = null;
                    this.canProceed = false;
                }
            }
        }));
    });
</script>
@endpush

@endsection