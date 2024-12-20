<div class="bg-[#155458] border-2 border-[#FAFAFA] w-full py-2 px-2 rounded-md transition duration-300 ease-in-out hover:scale-[1.02] cursor-pointer
    {{ $status === 'booked' ? 'bg-yellow-800' : 'bg-[#155458]' }} <!-- Conditional color based on status -->
">
<p class="text-[#FAFAFA] text-[1.1rem] font-bold">{{ $name}}</p>
    
    @if ($status === 'booked')
    <div class="flex justify-between">
        <p class="text-[#FAFAFA] text-[0.8rem]">Pukul {{ $time }}</p>
    </div>
    @else
    <p class="text-[#FAFAFA] text-[0.8rem]">Pukul {{ $time }}</p>

    @endif
</div>