<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <!-- Pastikan jQuery diload terlebih dahulu -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>Psychiatrist</title>
</head>
<body>
    <div class="flex justify-center items-center w-full h-[100vh] bg-login-gradient font-poppins px-10">
        <div class="relative flex flex-col w-[80vw] h-fit min-h-[85vh] pb-[10rem] bg-white rounded-[3rem] shadow-3xl">
            {{-- FORM KONTEN --}}
            @yield('konten')


              

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            const nextButton = document.getElementById('next-button');
    
            function updateButtonState() {
                const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
                if (allChecked) {
                    nextButton.classList.remove('pointer-events-none', 'opacity-50');
                } else {
                    nextButton.classList.add('pointer-events-none', 'opacity-50');
                }
            }
    
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateButtonState);
            });
                updateButtonState();
        });
    </script>
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#psikolog').select2();
        });
    </script>
    @endpush
</body>
</html>