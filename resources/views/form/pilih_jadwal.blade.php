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
        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 " role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="w-full flex flex-col gap-3">
        <label>Pilih jadwal</label>

        <div class="w-full h-[0.5rem] flex flex-col justify-center rounded-md overflow-hidden bg-[#155458] text-xs text-white text-center whitespace-nowrap transition duration-500 " role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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

    selectSchedule(scheduleId, psychologId) {
        this.activeCard = scheduleId;
        this.selectedScheduleId = scheduleId;
        this.selectedPsychologId = psychologId;
        this.canProceed = true;
        console.log('Selected Schedule:', scheduleId);
        console.log('Selected Psychologist:', psychologId);
    },

    generateNextUrl() {
        if (this.selectedScheduleId && this.selectedPsychologId) {
            return '{{ route('form.ketentuan_submit') }}?jadwal_id=' + this.selectedScheduleId + '&psikolog_id=' + this.selectedPsychologId;
        }
        return '#';
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
                        x-model="selectedPsychologId"
                        class="col-span-2 w-full text-xs h-7 border-[1px] border-[#4F4F4F] text-[#4F4F4F] rounded-2xl px-4"
                    >
                        @foreach ($psikologs as $psikolog)
                            <option value="{{ $psikolog->id }}">
                                {{ $psikolog->name }}
                            </option>
                        @endforeach
                    </select>
    
                    @php
                    $today = \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d');
                    @endphp
                    
                    <input 
                        type="date" 
                        id="tanggal" 
                        name="tanggal" 
                        class="col-span-2 w-full text-xs h-7 border-[1px] border-[#4F4F4F] text-[#4F4F4F] rounded-2xl px-4" 
                        value="{{ request('tanggal', $today) }}"
                    >                            
                    <button type="submit" class="col-span-1 font-bold text-white bg-[#155458] px-3 py-1 rounded-md">Cari</button>
                </form>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                @if ($jadwals && $jadwals->count() > 0)
                    @foreach ($jadwals as $jad)
                        @if ($jad->psikolog)
                            <div 
                                @click="selectSchedule({{ $jad->id }}, {{ $jad->psikolog->id }})"
                                :class="activeCard === {{ $jad->id }} ? 'bg-yellow-500 text-black border-yellow-300' : 'bg-[#155458] text-white border-[#FAFAFA]'" 
                                class="jadwal-card border-2 w-full py-2 px-2 rounded-md transition duration-300 ease-in-out hover:scale-[1.02] cursor-pointer"
                            >
                                <p class="text-[1.1rem] font-bold">{{ $jad->psikolog->name }}</p>
                                <p class="text-[0.8rem]">Pukul {{ \Carbon\Carbon::parse($jad->waktu)->setTimezone('Asia/Jakarta')->format('H:i') }} WIB</p>
                            </div>
                        @else
                            <p>No psychologist assigned</p>
                        @endif
                    @endforeach
                @else
                    <p>No schedules available</p>
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
            <a 
                id="next-button" 
                x-show="canProceed"
                x-bind:href="'{{ route('form.ketentuan_submit') }}?jadwal_id=' + selectedScheduleId + '&psikolog_id=' + selectedPsychologId"
                class="flex items-center gap-4"
            >
                <span class="text-[1.5rem] text-[#155458] font-bold">Next</span>
                <img src="{{ asset('images/next.png') }}" alt="Next">
            </a>
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

            selectSchedule(scheduleId, psychologId) {
                this.activeCard = scheduleId;
                this.selectedScheduleId = scheduleId;
                this.selectedPsychologId = psychologId;
                this.canProceed = true;
                console.log('Selected Schedule:', scheduleId);
                console.log('Selected Psychologist:', psychologId);
            },

            generateNextUrl() {
                if (this.selectedScheduleId && this.selectedPsychologId) {
                    return '{{ route('form.ketentuan_submit') }}?jadwal_id=' + this.selectedScheduleId + '&psikolog_id=' + this.selectedPsychologId;
                }
                return '#';
            }
        }));
    });
</script>
@endpush


@endsection