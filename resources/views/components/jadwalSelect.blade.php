<div 
    x-data="{ 
        id: {{ $jad->id }}, 
        psikologId: {{ $jad->psikolog->id ?? 'null' }} 
    }" 
    @click.prevent="
        activeCard = id; 
        selectedScheduleId = id;
        selectedPsychologId = psikologId;
        console.log('Selected Schedule:', selectedScheduleId);
        console.log('Selected Psychologist:', selectedPsychologId)"
    :class="activeCard === id ? 'bg-yellow-500 text-black border-yellow-300' : 'bg-[#155458] text-white border-[#FAFAFA]'" 
    class="jadwal-card border-2 w-full py-2 px-2 rounded-md transition duration-300 ease-in-out hover:scale-[1.02] cursor-pointer"
>
    <p class="text-[1.1rem] font-bold">{{ $jad->psikolog->name }}</p>
    <p class="text-[0.8rem]">Pukul {{ \Carbon\Carbon::parse($jad->waktu)->setTimezone('Asia/Jakarta')->format('H:i') }} WIB</p>
</div>