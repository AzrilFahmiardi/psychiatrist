<div class="bg-[#155458] border-2 border-[#FAFAFA] w-full py-2 px-2 rounded-md transition duration-300 ease-in-out hover:scale-[1.02] cursor-pointer
    {{ $status === 'booked' ? 'bg-opacity-50' : 'bg-[#155458]' }} <!-- Conditional color based on status -->
">
<p class="text-[#FAFAFA] text-[0.5rem] md:text-[0.8rem] lg:text-[1.1rem] font-bold">{{ $name ? $name : '-' }}</p>
    
    @if ($status === 'booked')
    <div class="flex justify-between">
        <p class="text-[#FAFAFA] text-[0.35rem] md:text-[0.5rem] lg:text-[0.8rem]">Pukul {{ $time }}</p>
        <p class="text-red-300 text-[0.35rem] md:text-[0.5rem] lg:text-[0.8rem] font-semibold">Telah di booking</p> <!-- Message for booked status -->

    </div>
    @else
    <p class="text-[#FAFAFA] text-[0.35rem] md:text-[0.5rem] lg:text-[0.8rem]">Pukul {{ $time }}</p>

    @endif
</div>


