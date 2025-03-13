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
    <div class="bg-[##FAFAFA] font-poppins px-10">
        <div class="min-h-screen w-full flex flex-col items-center">
            {{-- NAVBAR --}}
@if (Auth::check())
<nav class="w-full pt-7 pb-5 font-poppins text-[#155458] text-xl md:px-20 px-6 relative">
    <div class="flex justify-between items-center">
        <a href="/" class="font-bold">SV UGM</a>
        
        <!-- Hamburger Button -->
        <button type="button" onclick="toggleMenu()" class="md:hidden z-50 relative w-8 h-8 flex justify-center items-center">
            <div id="hamburger" class="flex flex-col justify-between w-6 h-5 transform transition-all duration-300">
                <span class="w-full h-0.5 bg-[#155458] transform transition-all duration-300"></span>
                <span class="w-full h-0.5 bg-[#155458] transform transition-all duration-300"></span>
                <span class="w-full h-0.5 bg-[#155458] transform transition-all duration-300"></span>
            </div>
        </button>

        <div class="hidden md:flex md:items-center md:gap-7">
            <a href="/">Home</a>
            <a href="{{ route('riwayat.booking') }}" class="font-bold">Riwayat</a>
        </div>

        <a href="{{ route('pasien.profile') }}" class="hidden md:block font-bold bg-transparent border-2 border-[#155458be] hover:bg-[#15545870] px-4 py-1 rounded-md">
            {{ Auth::user()->name }}
        </a>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="absolute top-full left-0 w-full bg-white border-2 border-[#155458] rounded-xl transform transition-all duration-300 -translate-y-full opacity-0 invisible md:hidden shadow-lg z-30">
        <div class="py-4 px-6 space-y-4">
            <a href="/" class="block hover:text-gray-600 transition-colors">Home</a>
            <a href="{{ route('riwayat.booking') }}" class="block font-bold hover:text-gray-600 transition-colors">Riwayat</a>
            <a href="{{ route('pasien.profile') }}" class="block font-bold bg-[#155458] text-white px-4 py-2 rounded-md hover:bg-[#15545870] w-fit">
                {{ Auth::user()->name }}
            </a>
        </div>
    </div>
</nav>
@else
<nav class="w-full pt-7 pb-5 font-poppins text-[#155458] text-xl md:px-20 px-6 relative">
    <div class="flex justify-between items-center">
        <a href="/" class="font-bold">SV UGM</a>
        
        <!-- Hamburger Button -->
        <button type="button" onclick="toggleMenu()" class="md:hidden z-50 relative w-8 h-8 flex justify-center items-center">
            <div id="hamburger" class="flex flex-col justify-between w-6 h-5 transform transition-all duration-300">
                <span class="w-full h-0.5 bg-[#155458] transform transition-all duration-300"></span>
                <span class="w-full h-0.5 bg-[#155458] transform transition-all duration-300"></span>
                <span class="w-full h-0.5 bg-[#155458] transform transition-all duration-300"></span>
            </div>
        </button>

        <div class="hidden md:flex md:items-center md:gap-7">
            <a href="/" class="font-bold">Home</a>
            <a href="#" onclick="showLoginModal(event)" class="font-bold">Riwayat</a>
        </div>

        <a href="/login" class="hidden md:block font-bold bg-[#155458] text-white px-4 py-1 rounded-md">Login</a>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="absolute top-full left-0 w-full bg-white border-2 border-[#155458] rounded-xl transform transition-all duration-300 -translate-y-full opacity-0 invisible md:hidden shadow-lg z-30">
        <div class="py-4 px-6 space-y-4">
            <a href="/" class="block font-bold hover:text-gray-600 transition-colors">Home</a>
            <a href="#" onclick="showLoginModal(event)" class="block font-bold hover:text-gray-600 transition-colors">Riwayat</a>
            <a href="/login" class="block font-bold bg-[#155458] text-white px-4 py-2 rounded-md hover:bg-[#15545870] w-fit">
                Login
            </a>
        </div>
    </div>
</nav>

<!-- Modal (unchanged) -->
<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-md text-center">
        <p class="text-lg">Silakan login untuk melihat riwayat</p>
        <div class="mt-4">
            <a href="/login" class="bg-[#155458] px-4 py-2 rounded-md text-white">Login</a>
            <button onclick="closePopup()" class="bg-gray-500 px-4 py-2 rounded-md text-white ml-2">Tutup</button>
        </div>
    </div>
</div>
@endif
<hr class="bg-[#00000080] h-[2px] w-full px-20">
{{-- END NAVBAR --}}


<div class="flex flex-col items-center justify-center">
    <h1 class="mt-10 text-[1rem] sm:text-[1.5rem]  md:text-[2rem] font-bold text-[#155458]">Privacy <span class="text-[#4F4F4F]">Policy</span></h1>
    <p class="text-xs">for SIKOLOV Web and App</p>
</div>


<div class="w-[80vw] my-10">
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Information Collection and Use</h2>
        <p class="mb-2"><span class="font-semibold">Personal Information:</span> We collect personal information, such as name, email address, phone number, and health-related details during the registration process or while using the SIKOLOV web and app. This information is used to schedule consultations, provide personalized psychological services, and facilitate communication between clients and psychologists.</p>
        <p class="mb-2"><span class="font-semibold">Consultation Details:</span> During sessions, clients may provide sensitive information, including psychological history and current concerns. This information will only be accessed by authorized psychologists and used to deliver effective care.</p>
        <p class="mb-2"><span class="font-semibold">Data Usage:</span> All collected information is used solely to facilitate and improve psychological services. We do not share personal information with third parties unless required by law or with explicit user consent.</p>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Data Security</h2>
        <p class="mb-2"><span class="font-semibold">Secure Login:</span> Users must securely log in to access the SIKOLOV web and app. Strong authentication measures, such as two-factor authentication, are implemented to protect user accounts.</p>
        <p class="mb-2"><span class="font-semibold">Encryption:</span> Data transmitted between the user's device and our servers is encrypted using industry-standard encryption protocols to ensure confidentiality.</p>
        <p class="mb-2"><span class="font-semibold">Data Storage:</span> All data is stored on secure servers with strict access controls. Access is limited to authorized personnel who are bound by confidentiality agreements.</p>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">User Rights</h2>
        <p class="mb-2"><span class="font-semibold">Access and Correction:</span> Users have the right to access and correct their personal information stored in the SIKOLOV system. They can update their profile or request corrections for inaccurate information.</p>
        <p class="mb-2"><span class="font-semibold">Data Deletion:</span> Users may request the deletion of their personal data. We will comply with such requests unless required to retain the data by law or for legitimate business purposes.</p>
        <p class="mb-2"><span class="font-semibold">Consent:</span> Explicit user consent is obtained before collecting, using, or sharing personal information. Users can withdraw their consent at any time.</p>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Communication and Notifications</h2>
        <p class="mb-2"><span class="font-semibold">Reminders:</span> Users will receive reminders for scheduled consultations via secure channels, such as in-app notifications or encrypted emails.</p>
        <p class="mb-2"><span class="font-semibold">Psychologist Communication:</span> Psychologists can communicate with clients directly through the SIKOLOV app to provide support and guidance between sessions.</p>
        <p class="mb-2"><span class="font-semibold">Educational Resources:</span> The SIKOLOV app and web provide access to articles, guides, and mental health tips to empower users with knowledge about psychological well-being.</p>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Third-Party Services</h2>
        <p class="mb-2"><span class="font-semibold">Payment Gateways:</span> The SIKOLOV platform may integrate with secure payment gateways to process fees for consultations. Users' payment details are subject to the respective payment gateway's privacy policy.</p>
        <p class="mb-2"><span class="font-semibold">Other Third-Party Services:</span> If additional third-party services are integrated, they will adhere to strict privacy and security standards. Users will be informed and have the option to opt-out if desired.</p>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Changes to the Privacy Policy</h2>
        <p class="mb-2">We reserve the right to modify this privacy policy at any time. Changes will be effective immediately upon posting the updated policy on the SIKOLOV web and app. Users are encouraged to review this policy periodically for updates.</p>
    </div>
</div>

<p class="text-center text-xs my-10">If you have any questions or concerns about our privacy practices, please contact us at (developer contact).</p>

            

        

        <!-- JavaScript untuk Modal -->
        <script>
            function showConsultationResult(doctor, date, result) {
                // Set data ke modal
                document.getElementById('consultationDoctor').textContent = doctor;
                document.getElementById('consultationDate').textContent = date;
                document.getElementById('consultationResult').textContent = result;
                // Tampilkan modal
                document.getElementById('consultationModal').classList.remove('hidden');
            }

            function closeConsultationModal() {
                // Sembunyikan modal
                document.getElementById('consultationModal').classList.add('hidden');
            }
        </script>
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
          </script>
          
<script>
    function toggleMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        const hamburger = document.getElementById('hamburger');
        const spans = hamburger.getElementsByTagName('span');
    
        if (mobileMenu.classList.contains('-translate-y-full')) {
            // Menu Opening
            mobileMenu.classList.remove('-translate-y-full', 'opacity-0', 'invisible');
            mobileMenu.classList.add('translate-y-0', 'opacity-100', 'visible');
            
            // Hamburger Animation
            spans[0].classList.add('rotate-45', 'translate-y-2');
            spans[1].classList.add('opacity-0');
            spans[2].classList.add('-rotate-45', '-translate-y-2');
        } else {
            // Menu Closing
            mobileMenu.classList.remove('translate-y-0', 'opacity-100', 'visible');
            mobileMenu.classList.add('-translate-y-full', 'opacity-0', 'invisible');
            
            // Hamburger Animation
            spans[0].classList.remove('rotate-45', 'translate-y-2');
            spans[1].classList.remove('opacity-0');
            spans[2].classList.remove('-rotate-45', '-translate-y-2');
        }
    }
    </script>
    </div>


</body>
</html>