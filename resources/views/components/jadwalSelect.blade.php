Copy<div 
    x-data="{ id: {{ $id }} }" 
    @click="activeCard = id"
    :class="activeCard === id ? 'bg-yellow-500 text-black border-yellow-300' : 'bg-[#155458] text-white border-[#FAFAFA]'" 
    class="jadwal-card border-2 w-full py-2 px-2 rounded-md transition duration-300 ease-in-out hover:scale-[1.02] cursor-pointer"
>
    <input type="hidden" name="selected_schedule" :value="id" x-show="activeCard === id">
    <p class="text-[1.1rem] font-bold">{{ $name }}</p>
    <p class="text-[0.8rem]">Pukul {{ $time }} WIB</p>
</div>