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
        <div class="relative flex flex-col w-[80vw] h-fit min-h-[85vh] pb-[10rem] bg-white rounded-[3rem] shadow-3xl">
            {{-- FORM KONTEN --}}
            @yield('konten')


              

        </div>
    </div>
</body>
</html>