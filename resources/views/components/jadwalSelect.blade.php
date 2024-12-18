<div 
    x-data="{ 
        id: {{ $jad->id }}, 
        psikologId: {{ $jad->psikolog->id ?? 'null' }},
        status: '{{ $jad->status }}'
    }" 
    @click.prevent="
        status === 'available' && (
            activeCard = id, 
            selectedScheduleId = id,
            selectedPsychologId = psikologId,
            console.log('Selected Schedule:', selectedScheduleId),
            console.log('Selected Psychologist:', selectedPsychologId)
        )"
    :class="{
        'bg-[#155458] text-white border-[#155458]': status === 'available' && activeCard !== id,
        'bg-yellow-500 text-black border-yellow-300': activeCard === id,
        'bg-gray-200 text-gray-500 border-gray-300 opacity-60': status === 'booked'
    }"
    class="jadwal-card border-2 w-full py-2 px-2 rounded-md transition duration-300 ease-in-out 
           {{ $jad->status === 'booked' ? 'cursor-not-allowed' : 'hover:scale-[1.02] cursor-pointer' }}"
>
    <p class="text-[1.1rem] font-bold">{{ $jad->psikolog->name }}</p>
    <p class="text-[0.8rem]">Pukul {{ \Carbon\Carbon::parse($jad->waktu)->setTimezone('Asia/Jakarta')->format('H:i') }} WIB</p>
    
    @if($jad->status === 'booked')
        <span class="text-xs text-red-500 block mt-1">Sudah Dibooking</span>
    @endif
</div>