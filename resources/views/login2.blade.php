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

  <div class="bg-login-gradient font-poppins px-10">
    <div class="min-h-screen w-full flex flex-col items-center py-10">
      <div class="font-poppins text-white my-10">
        {{-- <h1 class="text-white font-bold text-[2rem] md:text-[4.5rem]">SIKOLOV</h1>
        <p>Fasilitas konseling Sekolah Vokasi UGM</p> --}}
        <div class="flex flex-col items-center gap-2 md:gap-0">
          <img src="{{ asset('images/logo_sikolov_2.png') }}" alt="logo sikolov" class="w-3/5 md:w-full">
          <p class="md:text-base text-xs">Fasilitas konseling Sekolah Vokasi UGM</p>
        </div>  
      </div> 

      <div class="lg:w-[50vw] md:w-[90vw] flex justify-center items-center">
        <div class="flex flex-col item-center md:w-[70%] md:h-fit px-10 md:px-16 py-10 rounded-3xl bg-white shadow">
          <h2 class="text-[#155458] text-center text-[2.5rem] font-bold">Login</h2>
          
          {{-- Form Login --}}
          <form method="POST" action="{{ route('auth.nonPasien') }}" class="mt-16 space-y-4">
            @csrf

            <div>
              <div class="relative flex items-center">
                <input name="email" type="email" required class="w-full text-[#4F4F4F] text-sm border-[1px] border-[#155458] px-7 py-4 rounded-2xl outline-[#155458] placeholder:font-semibold placeholder:text-[#4F4F4F]" placeholder="Email" />
                <img src="images/email.png" alt="email" class="w-4 h-4 absolute right-4">
              </div>
            </div>

            <div>
              <div class="relative flex items-center">
                <input name="password" type="password" required class="w-full text-[#4F4F4F] text-sm border-[1px] border-[#155458] px-7 py-4 rounded-2xl outline-[#155458] placeholder:font-semibold placeholder:text-[#4F4F4F]" placeholder="Password" />
                <img src="images/password.png" alt="password" class="w-4 h-4 absolute right-4">
              </div>
            </div>

            {{-- <div class="flex flex-wrap items-center justify-between gap-4">
              <div class="flex items-center">
                <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                <label for="remember-me" class="ml-3 block text-sm text-gray-800">
                  Remember me
                </label>
              </div>
            </div> --}}

            <div class="!mt-16">
              <button type="submit" class="w-full py-5 px-4 font-bold text-sm tracking-wide rounded-2xl text-white bg-[#155458] hover:bg-[#155458da] focus:outline-none">
                Login
              </button>
            </div>
          </form>
          {{-- End of Form --}}
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Auto-dismiss messages after 5 seconds
      const messages = document.querySelectorAll('#flash-message-container > div');
      
      messages.forEach(function(message) {
        // Fade out after 5 seconds
        setTimeout(() => {
          message.classList.add('opacity-0', 'h-0', 'py-0');
        }, 5000);  // This is where the 5-second timing is set

        // Remove from DOM
        setTimeout(() => {
          message.remove();
        }, 5500);  // This is slightly after the fade-out to complete the animation
      });
    });
  </script>
</body>
</html>
