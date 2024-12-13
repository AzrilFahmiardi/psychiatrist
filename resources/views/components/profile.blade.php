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
    <div class="flex justify-center items-center w-full h-[100vh] bg-login-gradient font-poppins px-10">
        <div class="relative flex flex-col w-[80vw] h-fit  pb-10 bg-white rounded-[3rem] shadow-3xl">   
            <div class="w-full px-[10rem]">
                <h1 class="text-center text-[#155458] text-xl font-bold my-10">Pengisian data pribadi</h1>  
                <form action="{{ route('pasien.update')}}" method="post">
                    @csrf
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="nama" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">Nama pendaftar</label>
                            <input type="text" id="nama" name="nama_lengkap" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl focus:ring-blue-500 focus:border-blue-500 block w-full py-[1rem] px-4" placeholder="nama lengkap" value="{{ $user ? $user->nama_lengkap : '' }}" required />
                        </div>
                        <div class="relative">
                            <label for="program_studi" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">Program studi</label>
                            <select id="program_studi" name="program_studi" class="select2 border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl focus:ring-blue-500 focus:border-blue-500 block w-full py-[1rem] px-4 appearance-none bg-[url('{{ asset('images/down-arrow.svg') }}')] bg-no-repeat bg-right-[10px] bg-center">
                                @foreach ($prodi as $prod)
                        <option value="{{ $prod->name }}" 
                            {{ $user->program_studi == $prod->name ? 'selected' : '' }}>
                            {{ $prod->name }}
                        </option>
                    @endforeach
                            </select>
                            <img src="{{ asset('images/down-arrow.png') }}" alt="" class="absolute bottom-[1.1rem] right-7 ">
                                       
                        </div>
                        <div>
                            <label for="semester" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">semester</label>
                            <input type="number" id="company" name="semester"  min="1" max="14" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl  block w-full py-[1rem] px-4 " value="{{ $user ? $user->semester : '' }}" placeholder="contoh : 6" required />
                        </div>  
                        <div>
                            <label class="block mb-5 text-sm font-semibold text-[1rem] text-[#155458]">Jenis Kelamin</label>
                            <div class="flex items-center mt-2 text-[#155458]">
                                <label for="laki-laki" class="inline-flex items-center mr-6">
                                    <input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki" class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" {{ $user && $user->jenis_kelamin == 'laki-laki' ? 'checked' : '' }}
                                    class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]">
                                    <span class="ml-2">Laki-laki</span>
                                </label>
                                <label for="perempuan" class="inline-flex items-center">
                                    <input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan" class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" {{ $user && $user->jenis_kelamin == 'perempuan' ? 'checked' : '' }}
                                    class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]">
                                    <span class="ml-2">Perempuan</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label for="usia" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">Usia</label>
                            <input type="number" id="usia" name="usia"  min="0" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl  block w-full py-[1rem] px-4  " value="{{ $user ? $user->usia : '' }}" placeholder="contoh : 20" required />
                        </div>
                        <div>
                            <label for="no_hp" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">No. HP/WA</label>
                            <input type="text" id="no_hp" name="no_hp" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl  block w-full py-[1rem] px-4  " value="{{ $user ? $user->no_hp : '' }}" placeholder="contoh : 08****" required />
                        </div>
                        <div class="relative">
                            <label for="departemen" class="block mb-2 text-sm font-semibold text-[1rem] text-[#155458]">Asal departemen</label>
                            
                            @foreach($departemen as $dep)
                            @php
                                $departemenList[] = $dep->name;
                            @endphp
                            @endforeach
                            <select id="departemen" name="departemen" class="border-[1px] border-[#4F4F4F] text-[#4F4F4F] text-sm rounded-2xl focus:ring-blue-500 focus:border-blue-500 block w-full py-[1rem] px-4 appearance-none bg-[url('{{ asset('images/down-arrow.svg') }}')] bg-no-repeat bg-right-[10px] bg-center">
                                @foreach ($departemen as $dep)
                                <option value="{{ $dep->name }}" 
                                    {{ $user->departemen == $dep->name ? 'selected' : '' }}>
                                    {{ $dep->name }}
                                </option>
                            @endforeach
                            </select>
                            <img src="{{ asset('images/down-arrow.png') }}" alt="" class="absolute bottom-[1.1rem] right-7 ">
                                       
                        </div>
                        <div>
                            <label class="block mb-5 text-sm font-semibold text-[1rem] text-[#155458]">Layanan kesehatan mental yang pernah atau sedang diakses</label>
                            <div class="flex items-center mt-2 text-[#155458]">
                                <label for="psikolog" class="inline-flex items-center mr-6">
                                    <input type="radio" id="psikolog" name="status_akses_layanan" value="psikolog" class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" {{ $user && $user->status_akses_layanan == 'psikolog' ? 'checked' : '' }}>
                                    <span class="ml-2">Psikolog</span>
                                </label>
                                <label for="psikiater" class="inline-flex items-center mr-6">
                                    <input type="radio" id="psikiater" name="status_akses_layanan" value="psikiater" class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" {{ $user && $user->status_akses_layanan == 'psikiater' ? 'checked' : '' }}>
                                    <span class="ml-2">Psikiater</span>
                                </label>
                                <label for="belum" class="inline-flex items-center">
                                    <input type="radio" id="belum" name="status_akses_layanan" value="belum pernah" class="form-radio border-[#155458] focus:ring-[#155458] text-[#155458]" {{ $user && $user->status_akses_layanan == 'belum pernah' ? 'checked' : '' }}>
                                    <span class="ml-2">Belum pernah</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="flex justify-between mt-20 gap-5">
                        <a href="/" class="flex items-center gap-4">
                            <img src="{{ asset('images/back.png') }}" alt="Back" class="w-7">
                            <span class="text-[1.1rem] text-[#155458] font-bold">Back to home</span>
                        </a>                        
                        <div>
                            <button type="submit" class="font-bold text-white bg-[#155458] px-6 py-3 rounded-md">Update</button>
                            <a href="{{ route('google.logout') }}" class="font-bold text-white bg-[#155458] px-6 py-3 rounded-md">Logout</a>
                        </div>               
                    </div>
                        
                </form>
            </div>
              

        </div>
    </div>

</body>
</html>




