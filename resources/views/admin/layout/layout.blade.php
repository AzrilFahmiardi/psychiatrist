<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <!-- Material Icons Link -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
        integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
        crossorigin="anonymous" />
    <title>SIKOLOV</title>
</head>

<body class="relative">
    <button class="md:hidden p-4 absolute right-0 top-0" data-sidebar-toggle>
        <i class="fas fa-bars text-xl" data-sidebar-icon></i>
    </button>
    <div class="fixed inset-0 bg-black bg-opacity-50 hidden" data-sidebar-overlay></div>
    <div id="app" class="flex">
        <!-- Sidebar Start -->
        <aside data-sidebar
            class="fixed z-20 left-0 top-0 flex flex-col bg-clip-border rounded-xl transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out bg-white text-gray-700 h-screen w-[20rem] p-6 shadow-md">
            <div class="mb-2 flex items-center gap-4 p-4">
                {{-- <img src="https://www.material-tailwind.com/logos/mt-logo.png" alt="brand" class="h-9 w-9" /> --}}
                <p class="block antialiased font-sans leading-relaxed text-teal-900 text-lg font-bold">
                   Admin SiKOLOV
                </p>
            </div>
            
            <nav class="flex flex-col gap-1 p-2 text-gray-700">
                <!-- Contoh Accordion Item -->
                {{-- <div>
                    <div data-ripple-dark="true"
                        class="flex items-center p-3 rounded-lg transition-all hover:bg-gray-50 cursor-pointer"
                        data-accordion-button>
                        <div class="grid place-items-center mr-4">
                            <img src="https://www.material-tailwind.com/img/avatar1.jpg" class="w-9 h-9 rounded-full" />
                        </div>
                        <p class="mr-auto font-normal">Brooklyn Alice</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                            stroke="currentColor" class="ml-auto h-4 w-4 text-gray-500 transition-transform"
                            data-accordion-icon>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    <div class="max-h-0 overflow-hidden transition-all duration-300" data-accordion-content>
                        <nav class="flex flex-col gap-1 px-4 pb-2 text-sm text-gray-700">
                            <a data-ripple-dark="true" href="#" class="block p-2 hover:bg-gray-100 rounded">My
                                Profile</a>
                            <a data-ripple-dark="true"href="#" class="block p-2 hover:bg-gray-100 rounded">Settings</a>
                        </nav>
                    </div>
                </div>
                <hr class="my-2 border-gray-200" /> --}}

                <!-- Accordion Dashboard -->
                {{-- <div>
                    <div data-ripple-dark="true"
                        class="flex items-center p-3 rounded-lg transition-all hover:bg-gray-50 cursor-pointer"
                        data-accordion-button>
                        <div class="grid place-items-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="h-5 w-5">
                                <path fill-rule="evenodd"
                                    d="M1.5 7.125c0-1.036.84-1.875 1.875-1.875h6c1.036 0 1.875.84 1.875 1.875v3.75c0 1.036-.84 1.875-1.875 1.875h-6A1.875 1.875 0 0 1 1.5 10.875v-3.75Zm12 1.5c0-1.036.84-1.875 1.875-1.875h5.25c1.035 0 1.875.84 1.875 1.875v8.25c0 1.035-.84 1.875-1.875 1.875h-5.25a1.875 1.875 0 0 1-1.875-1.875v-8.25ZM3 16.125c0-1.036.84-1.875 1.875-1.875h5.25c1.036 0 1.875.84 1.875 1.875v2.25c0 1.035-.84 1.875-1.875 1.875h-5.25A1.875 1.875 0 0 1 3 18.375v-2.25Z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="mr-auto font-normal">Dashboard</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                            stroke="currentColor" class="ml-auto h-4 w-4 text-gray-500 transition-transform"
                            data-accordion-icon>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    <div class="max-h-0 overflow-hidden transition-all duration-300" data-accordion-content>
                        <nav class="flex flex-col gap-1 px-4 pb-2 text-sm text-gray-700">
                            <a data-ripple-dark="true" href="#"
                                class="block p-2 ms-6 hover:bg-gray-100 rounded">Analytics</a>
                            <a data-ripple-dark="true" href="#"
                                class="block p-2 ms-6 hover:bg-gray-100 rounded">Sales</a>
                        </nav>
                    </div>
                </div> --}}
                <!-- Menu lain seperti Products, Orders, dsb bisa langsung dibuat link biasa atau dijadikan accordion juga -->
            </nav>
            <hr class="my-2 border-gray-200" />
            <nav class="flex flex-col gap-1 min-w-[240px] p-2 font-sans text-base font-normal text-gray-700">
                <a href="{{ route('admin.psikologs.index') }}" role="button" data-ripple-dark="true" tabindex="0"
                    class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-opacity-80 focus:bg-opacity-80 active:bg-opacity-80 outline-none select-none hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-100 hover:text-gray-900 focus:text-gray-900 active:text-gray-900 cursor-pointer {{ Request::is('admin/psikologs*') ? 'text-teal-600' : '' }}">
                    <div class="grid place-items-center mr-4">
                        <i class="fa fa-users"></i>
                    </div>
                    Psikolog
                </a>
                <a href="{{ route('admin.jadwals.index') }}" role="button" data-ripple-dark="true" tabindex="0"
                    class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-opacity-80 focus:bg-opacity-80 active:bg-opacity-80 outline-none select-none hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-100 hover:text-gray-900 focus:text-gray-900 active:text-gray-900 cursor-pointer {{ Request::is('admin/jadwals*') ? 'text-teal-600' : '' }}">
                    <div class="grid place-items-center mr-5">
                        <i class="fa fa-calendar"></i>
                    </div>
                    Jadwal
                </a>
                <a href="{{ route('admin.bookings.index') }}" role="button" data-ripple-dark="true" tabindex="0"
                    class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-opacity-80 focus:bg-opacity-80 active:bg-opacity-80 outline-none select-none hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-100 hover:text-gray-900 focus:text-gray-900 active:text-gray-900 cursor-pointer {{ Request::is('admin/bookings*') ? 'text-teal-600' : '' }}">
                    <div class="grid place-items-center mr-5">
                        <i class="fa fa-clipboard"></i>
                    </div>
                    Booking
                </a>
                <a href="{{ route('admin.users.index') }}" role="button" data-ripple-dark="true" tabindex="0"
                    class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-opacity-80 focus:bg-opacity-80 active:bg-opacity-80 outline-none select-none hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-100 hover:text-gray-900 focus:text-gray-900 active:text-gray-900 cursor-pointer {{ Request::is('admin/users*') ? 'text-teal-600' : '' }}">
                    <div class="grid place-items-center mr-5">
                        <i class="fa fa-user"></i>
                    </div>
                    Pengguna
                </a>
                <a href="{{ route('google.logout') }}" role="button" data-ripple-dark="true" tabindex="0"
                    class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-opacity-80 focus:bg-opacity-80 active:bg-opacity-80 outline-none select-none hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-100 hover:text-gray-900 focus:text-gray-900 active:text-gray-900">
                    <div class="grid place-items-center mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" aria-hidden="true" data-slot="icon" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15">
                            </path>
                        </svg>
                    </div>
                    Sign Out
                </a>
            </nav>
            <div role="alert"
                class="relative w-full font-sans text-base font-regular px-4 py-4 rounded-lg bg-green-500/20 text-green-900 mt-auto flex"
                style="opacity: 0">
                {{-- <div class="mr-12">
                    <p class="block antialiased font-sans text-sm leading-normal text-green-500 mb-1 font-bold">
                        New Version Available
                    </p>
                    <p class="block antialiased font-sans text-sm leading-normal text-green-500 font-normal">
                        Update your app and enjoy the new features and improvements.
                    </p>
                    <div class="mt-4 flex gap-4">
                        <a href="#"
                            class="block antialiased font-sans text-sm leading-normal text-green-500 font-normal">Dismiss</a><a
                            href="#"
                            class="block antialiased font-sans text-sm leading-normal text-green-500 font-medium">Upgrade
                            Now</a>
                    </div>
                </div> --}}
            </div>
            <p
                class=" antialiased font-sans text-sm  leading-normal text-inherit mt-5 font-medium text-gray-500 flex justify-center">
                SIKOLOV &copy; 2025
            </p>
        </aside>
        <!-- Sidebar End -->

        <!-- Main Content -->
        <div class="md:ms-[18em] w-full p-6">
            @yield('content')
        </div>
    </div>

    @vite('resources/js/app.js')
    <script async src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Handle Accordion
            const accordionButtons = document.querySelectorAll('[data-accordion-button]');
            accordionButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const content = button.nextElementSibling;
                    const icon = button.querySelector('[data-accordion-icon]');

                    // Check if open
                    if (content.style.maxHeight && content.style.maxHeight !== '0px') {
                        // Close accordion
                        content.style.maxHeight = '0px';
                        icon.style.transform = 'rotate(0deg)';
                    } else {
                        // Buka accordion yang diklik
                        content.style.maxHeight = content.scrollHeight + 'px';
                        icon.style.transform = 'rotate(180deg)';
                    }
                });
            });

            // Handle Sidebar Toggle (Mobile)
            const sidebar = document.querySelector('[data-sidebar]');
            const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
            const sidebarIcon = document.querySelector('[data-sidebar-icon]');
            const sidebarOverlay = document.querySelector('[data-sidebar-overlay]');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
                // Ubah icon ke X
                sidebarIcon.classList.remove('fa-bars');
                sidebarIcon.classList.add('fa-times');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                // Ubah icon ke bars
                sidebarIcon.classList.remove('fa-times');
                sidebarIcon.classList.add('fa-bars');
            }

            sidebarToggle.addEventListener('click', () => {
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            // Klik di luar sidebar (overlay) untuk menutup
            sidebarOverlay.addEventListener('click', () => {
                closeSidebar();
            });

            // Pada viewport desktop, pastikan overlay hilang dan sidebar terbuka normal
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    // Desktop
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                    sidebarIcon.classList.remove('fa-times');
                    sidebarIcon.classList.add('fa-bars');
                } else {
                    // Mobile, tutup sidebar secara default
                    sidebar.classList.add('-translate-x-full');
                }
            });
        });
    </script>
</body>

</html>
