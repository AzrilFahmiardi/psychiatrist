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
    <div class="bg-login-gradient font-poppins px-10">
        <div class="min-h-screen w-full grid grid-cols-2 py-6 px-4">
            <div class="flex my-auto mt-[10rem] p-10">
                <h1 class="text-white font-bold text-[4.5rem] text-shadow">Fasilitas Konseling Sekolah Vokasi UGM</h1>
            </div> 
            <div class=" w-[50vw] flex justify-center items-center">  
            <div class="md:w-[70%] md:h-[800px] px-10 md:px-16 py-16 rounded-3xl bg-white shadow">
              <h2 class="text-[#155458] text-center text-[2.5rem] font-bold">Register</h2>
              <p class="text-xs my-5 text-center">Login untuk mulai melakukan pendaftaran konseling</p>
              <form class="mt-16 space-y-4">
                <div>
                  <div class="relative flex items-center">
                    <input name="username" type="email" required class="w-full text-[#4F4F4F] text-sm border-[1px] border-[#155458] px-7 py-4 rounded-2xl outline-[#155458] placeholder:font-semibold placeholder:text-[#4F4F4F]" placeholder="Email" />
                    <img src="images/email.png" alt="email" class="w-4 h-4 absolute right-4">
                  </div>
                </div>
  
                <div>
                  <div class="relative flex items-center">
                    <input name="password" type="password" required class="w-full text-[#4F4F4F] text-sm border-[1px] border-[#155458] px-7 py-4 rounded-2xl outline-[#155458] placeholder:font-semibold placeholder:text-[#4F4F4F]" placeholder="Password" />
                    <img src="images/password.png" alt="email" class="w-4 h-4 absolute right-4">
                  </div>
                </div>
  
                <div class="flex flex-wrap items-center justify-between gap-4">
                  <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                    <label for="remember-me" class="ml-3 block text-sm text-gray-800">
                      Remember me
                    </label>
                  </div>
                  {{-- <div class="text-sm">
                    <a href="jajvascript:void(0);" class="text-blue-600 hover:underline font-semibold">
                      Forgot your password?
                    </a>
                  </div> --}}
                </div>
  
                <div class="!mt-16">
                  <button type="button" class="w-full py-5 px-4 font-bold  text-sm tracking-wide rounded-2xl text-white bg-[#155458] hover:bg-[#155458da] focus:outline-none">
                    Register
                  </button>
                </div>
                <p class="text-gray-800 text-sm !mt-8 text-center">Don't have an account? <a href="javascript:void(0);" class="text-[#155458] hover:underline ml-1 whitespace-nowrap font-semibold">Register here</a></p>
              </form>
            </div>
            </div>
        </div>
      </div>
</body>
</html>