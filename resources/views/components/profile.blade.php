<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>SIKOLOV</title>
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
    <div class="flex justify-center items-center w-full md:h-[100vh] bg-login-gradient font-poppins py-10 md:py-0 px-10">
        <div class="relative flex flex-col w-[80vw] h-fit  pb-10 bg-white rounded-xl md:rounded-[3rem] shadow-3xl">   
            <div class="w-full px-4 md:px-[10rem]">
                <h1 class="text-center text-[#155458] text-xl font-bold my-10">Pengisian data pribadi</h1>  
                <form action="{{ route('pasien.update')}}" method="post">
                    @csrf
                    <div class="grid gap-4 md:gap-6 mb-6 grid-cols-1 md:grid-cols-2">
                        <div>
                            <label for="nama" class="block mb-2 text-xs md:text-sm font-semibold text-[#155458]">Nama pendaftar</label>
                            <input type="text" id="nama" name="nama_lengkap" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-xs md:text-sm rounded-lg md:rounded-2xl block w-full py-2 md:py-[1rem] px-4" placeholder="nama lengkap" value="{{ $user ? $user->nama_lengkap : '' }}" required />
                        </div>
                        <div class="relative">
                            <label for="program_studi" class="block mb-2 text-xs md:text-sm font-semibold text-[#155458]">Program studi</label>
                            <select id="program_studi" name="program_studi" class="select2 border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-xs md:text-sm rounded-lg md:rounded-2xl block w-full py-2 md:py-[1rem] px-4 appearance-none bg-[url('{{ asset('images/down-arrow.svg') }}')] bg-no-repeat bg-right-[10px] bg-center">
                                @foreach ($prodi as $prod)
                                    <option value="{{ $prod->id }}" data-departemen="{{ $prod->departemen_id }}" {{ $user->program_studi == $prod->id ? 'selected' : '' }}>
                                        {{ $prod->name }}
                                    </option>
                                @endforeach
                            </select>
                            <img src="{{ asset('images/down-arrow.png') }}" alt="" class="absolute bottom-3 md:bottom-[1.1rem] right-7">
                        </div>
                        <div>
                            <label for="semester" class="block mb-2 text-xs md:text-sm font-semibold text-[#155458]">semester</label>
                            <input type="number" id="company" name="semester" min="1" max="14" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-xs md:text-sm rounded-lg md:rounded-2xl block w-full py-2 md:py-[1rem] px-4" value="{{ $user ? $user->semester : '' }}" placeholder="contoh : 6" required />
                        </div>
                        <div>
                            <label class="block mb-3 md:mb-5 text-xs md:text-sm font-semibold text-[#155458]">Jenis Kelamin *</label>
                            <div class="flex flex-col md:flex-row items-start md:items-center gap-2 md:gap-0 mt-2 text-[#155458]">
                                <label for="laki-laki" class="inline-flex text-xs md:text-sm items-center mr-0 md:mr-6">
                                    <input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki" 
                                    class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" 
                                    {{ $user && $user->jenis_kelamin == 'laki-laki' ? 'checked' : '' }}
                                    required>
                                    <span class="ml-2">Laki-laki</span>
                                </label>
                                <label for="perempuan" class="inline-flex text-xs md:text-sm items-center">
                                    <input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan" 
                                    class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" 
                                    {{ $user && $user->jenis_kelamin == 'perempuan' ? 'checked' : '' }}
                                    required>
                                    <span class="ml-2">Perempuan</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label for="usia" class="block mb-2 text-xs md:text-sm font-semibold text-[#155458]">Usia</label>
                            <input type="number" id="usia" name="usia" min="0" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-xs md:text-sm rounded-lg md:rounded-2xl block w-full py-2 md:py-[1rem] px-4" value="{{ $user ? $user->usia : '' }}" placeholder="contoh : 20" required />
                        </div>
                        <div>
                            <label for="no_hp" class="block mb-2 text-xs md:text-sm font-semibold text-[#155458]">No. HP/WA</label>
                            <input type="text" id="no_hp" name="no_hp" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-xs md:text-sm rounded-lg md:rounded-2xl block w-full py-2 md:py-[1rem] px-4" value="{{ $user ? $user->no_hp : '' }}" placeholder="contoh : 08****" required />
                        </div>
                        <div class="relative">
                            <label for="departemen" class="block mb-2 text-xs md:text-sm font-semibold text-[#155458]">Asal departemen</label>
                            <select id="departemen" name="departemen" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-xs md:text-sm rounded-lg md:rounded-2xl block w-full py-2 md:py-[1rem] px-4 appearance-none bg-[url('{{ asset('images/down-arrow.svg') }}')] bg-no-repeat bg-right-[10px] bg-center">
                                @foreach ($departemen as $dep)
                                    <option value="{{ $dep->id }}" {{ $user->departemen == $dep->id ? 'selected' : '' }}>
                                        {{ $dep->name }}
                                    </option>
                                @endforeach
                            </select>
                            <img src="{{ asset('images/down-arrow.png') }}" alt="" class="absolute bottom-3 md:bottom-[1.1rem] right-7">
                        </div>
                        <div>
                            <label class="block mb-3 md:mb-5 text-xs md:text-sm font-semibold text-[#155458]">Layanan kesehatan mental yang pernah atau sedang diakses *</label>
                            <div class="flex flex-col md:flex-row items-start md:items-center gap-2 md:gap-0 mt-2 text-[#155458]">
                                <label for="psikolog" class="inline-flex text-xs md:text-sm items-center mr-0 md:mr-6">
                                    <input type="radio" id="psikolog" name="status_akses_layanan" value="psikolog" 
                                    class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" 
                                    {{ $user && $user->status_akses_layanan == 'psikolog' ? 'checked' : '' }}
                                    required>
                                    <span class="ml-2">Psikolog</span>
                                </label>
                                <label for="psikiater" class="inline-flex text-xs md:text-sm items-center mr-0 md:mr-6">
                                    <input type="radio" id="psikiater" name="status_akses_layanan" value="psikiater" 
                                    class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" 
                                    {{ $user && $user->status_akses_layanan == 'psikiater' ? 'checked' : '' }}
                                    required>
                                    <span class="ml-2">Psikiater</span>
                                </label>
                                <label for="belum" class="inline-flex text-xs md:text-sm items-center">
                                    <input type="radio" id="belum" name="status_akses_layanan" value="belum pernah" 
                                    class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" 
                                    {{ $user && $user->status_akses_layanan == 'belum pernah' ? 'checked' : '' }}
                                    required>
                                    <span class="ml-2">Belum pernah</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between mt-10 md:mt-20 gap-5">
                        @if($user && $user->nama_lengkap)
                            <a href="/" class="flex items-center gap-4">
                                <img src="{{ asset('images/back.png') }}" alt="Back" class="w-5 md:w-7">
                                <span class="text-sm md:text-[1.1rem] text-[#155458] font-bold">Back to home</span>
                            </a>
                        @endif
                        <div class="flex flex-col md:flex-row gap-3 md:gap-4">
                            <button type="submit" class="font-bold text-white bg-[#155458] px-4 md:px-6 py-2 md:py-3 rounded-md text-sm md:text-base">Submit</button>
                            <a href="{{ route('google.logout') }}" class="font-bold text-white bg-[#155458] px-4 md:px-6 py-2 md:py-3 rounded-md text-sm md:text-base text-center">Logout</a>
                        </div>
                    </div>
                </form>
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

        const departemenSelect = document.getElementById('departemen');
        const programStudiSelect = document.getElementById('program_studi');
        const programStudiOptions = programStudiSelect.querySelectorAll('option');

        function filterProgramStudi() {
            const selectedDepartemen = departemenSelect.value;
            programStudiOptions.forEach(option => {
                option.style.display = option.getAttribute('data-departemen') === selectedDepartemen ? 'block' : 'none';
            });
            programStudiSelect.value = '';
        }

        departemenSelect.addEventListener('change', filterProgramStudi);
        filterProgramStudi(); // Initial filter on page load
      </script>
</body>
</html>




