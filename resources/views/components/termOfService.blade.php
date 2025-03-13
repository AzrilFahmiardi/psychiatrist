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
    <h1 class="mt-10 text-[1rem] sm:text-[1.5rem]  md:text-[2rem] font-bold text-[#155458]"><span class="text-[#4F4F4F]">Term of</span> Service</h1>
    <p class="text-xs">for SIKOLOV Web and App</p>
</div>


<div class="w-[80vw] my-10">
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Acceptance of Terms</h2>
        <p>Welcome to SIKOLOV, a platform for psychological consultation. By accessing or using the SIKOLOV web or app, you agree to comply with these Terms of Service. If you do not agree with these terms, please do not use the platform.</p>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Eligibility</h2>
        <ul class="list-disc pl-5">
            <li>You must be at least 18 years old to use the SIKOLOV platform. If you are under 18, parental or guardian consent is required.</li>
            <li>You affirm that the information provided during registration is accurate, complete, and current.</li>
        </ul>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">User Responsibilities</h2>
        <ul class="list-disc pl-5">
            <li>Users are responsible for maintaining the confidentiality of their account credentials and ensuring that no unauthorized person accesses their account.</li>
            <li>You agree not to use the platform for any unlawful activities or to disrupt the operations of SIKOLOV.</li>
            <li>Users must provide truthful and accurate information during consultations.</li>
        </ul>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Services Provided</h2>
        <ul class="list-disc pl-5">
            <li>SIKOLOV offers psychological consultation services, including scheduling sessions with licensed psychologists and accessing mental health resources.</li>
            <li>The platform does not replace medical advice or emergency services. If you are experiencing a mental health crisis, please contact local emergency services immediately.</li>
        </ul>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Payment and Fees</h2>
        <ul class="list-disc pl-5">
            <li>Payment for consultations must be made through the secure payment gateways integrated into the platform.</li>
            <li>Fees are subject to change, and users will be informed of any changes prior to scheduling sessions.</li>
            <li>Refund policies will be clearly outlined during the payment process and are subject to specific terms.</li>
        </ul>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Privacy and Data Protection</h2>
        <ul class="list-disc pl-5">
            <li>User data is collected, stored, and processed in accordance with our Privacy Policy.</li>
            <li>By using SIKOLOV, you consent to the collection and use of your data as outlined in the Privacy Policy.</li>
        </ul>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Intellectual Property</h2>
        <ul class="list-disc pl-5">
            <li>All content, including text, graphics, logos, and software, is the property of SIKOLOV or its licensors and is protected by intellectual property laws.</li>
            <li>Users may not copy, distribute, modify, or create derivative works based on the platform’s content without explicit permission.</li>
        </ul>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Limitation of Liability</h2>
        <ul class="list-disc pl-5">
            <li>SIKOLOV and its affiliates are not liable for any direct, indirect, incidental, or consequential damages resulting from the use of the platform.</li>
            <li>The platform is provided “as is,” and we do not guarantee uninterrupted or error-free operation.</li>
        </ul>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Modifications to Terms</h2>
        <ul class="list-disc pl-5">
            <li>SIKOLOV reserves the right to modify these Terms of Service at any time. Users will be notified of significant changes via email or platform notifications.</li>
            <li>Continued use of the platform after changes constitute acceptance of the revised terms.</li>
        </ul>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Governing Law and Dispute Resolution</h2>
        <ul class="list-disc pl-5">
            <li>These terms are governed by the laws.</li>
            <li>Any disputes arising from these terms will be resolved through negotiation, mediation, or arbitration, as deemed appropriate.</li>
        </ul>
    </div>
    <div class="mb-5">
        <h2 class="font-bold text-lg mb-2">Contact Information</h2>
        <p>If you have questions or concerns about these Terms of Service, please contact us at [developer contact information].</p>
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