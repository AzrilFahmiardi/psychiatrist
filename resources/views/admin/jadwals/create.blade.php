@extends('admin.layout.layout')

@section('title', 'Admin - Tambah Jadwal Psikolog')

@section('content')
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header dan Deskripsi -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold mb-2 text-gray-800">Admin - Tambah Jadwal Psikolog</h1>
            <p class="text-sm text-gray-600">Gunakan form ini untuk menambahkan jadwal baru untuk psikolog.</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 text-red-700 border border-red-100 rounded-md">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Jadwal -->
        <div class="bg-white shadow-sm rounded-md p-6">
            <form action="{{ route('admin.jadwals.store') }}" method="POST" class="space-y-6" id="jadwal-form">
                @csrf

                <!-- Pilih Psikolog -->
                <div class="relative">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Pilih Psikolog</label>
                    <select name="psikolog_id"
                        class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer"
                        required>
                        <option value="">-- Pilih Psikolog --</option>
                        @foreach ($psikologs as $psikolog)
                            <option value="{{ $psikolog->id }}" {{ old('psikolog_id') == $psikolog->id ? 'selected' : '' }}>
                                {{ $psikolog->nama_lengkap }} ({{ $psikolog->email }})
                            </option>
                        @endforeach
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2"
                        stroke="currentColor"
                        class="h-5 w-5 ml-1 absolute top-9 right-3 text-slate-700 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                    </svg>
                </div>

                <!-- Pilih Tanggal dan Sesi -->
                <div id="dates-container">
                    <div class="date-session-group mb-4 p-4 border border-gray-200 rounded-md">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-md font-semibold text-gray-700">Tanggal dan Sesi</h2>
                            <button type="button" class="text-red-500 hover:text-red-700"
                                onclick="removeDateSession(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Pilih Tanggal -->
                        <!-- Pilih Tanggal -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Pilih Tanggal</label>
                            <input type="date" name="dates[]"
                                min="{{ now()->timezone('Asia/Jakarta')->format('Y-m-d') }}"
                                class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                                required>
                        </div>

                        <!-- Pilih Sesi -->
                        <div class="mt-4">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Pilih Sesi</label>
                            <div class="flex flex-col h-32 flex-wrap gap-2">
                                @foreach ($sessions as $timeKey => $timeValue)
                                    <div class="flex items-center">
                                        <input type="checkbox" id="session_{{ $timeKey }}_0" name="sessions[0][]"
                                            value="{{ $timeValue }}" class="mr-2">
                                        <label for="session_{{ $timeKey }}_0"
                                            class="text-sm text-gray-700">{{ $timeValue }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-sm text-gray-500 mt-2">* Sesi dimulai dari jam genap (e.g., 08:00, 09:00).</p>
                        </div>
                    </div>
                </div>

                <!-- Tombol Tambah Tanggal dan Sesi -->
                <div>
                    <button type="button" class="px-4 py-2 bg-teal-500 text-white rounded hover:bg-teal-600 transition"
                        onclick="addDateSession()">Tambah Tanggal & Sesi</button>
                </div>

                <!-- Jumlah Ulangi -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Jumlah Ulangi (Minggu)</label>
                    <input type="number" name="weeks" min="1" max="10" value="{{ old('weeks', 1) }}"
                        class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                        placeholder="1" required />
                    <p class="text-sm text-gray-500 mt-1">* Maksimal 10 minggu.</p>
                </div>

                <!-- Tombol Simpan dan Kembali -->
                <div class="flex items-center space-x-4">
                    <button type="submit"
                        class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 transition">Simpan</button>
                    <a href="{{ route('admin.jadwals.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Template untuk Date & Session Group -->
    <template id="date-session-template">
        <div class="date-session-group mb-4 p-4 border border-gray-200 rounded-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-md font-semibold text-gray-700">Tanggal dan Sesi</h2>
                <button type="button" class="text-red-500 hover:text-red-700" onclick="removeDateSession(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Pilih Tanggal -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Pilih Tanggal</label>
                <input type="date" name="dates[]"
                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                    required>
            </div>

            <!-- Pilih Sesi -->
            <div class="mt-4">
                <label class="block mb-2 text-sm font-medium text-gray-700">Pilih Sesi</label>
                <div class="flex flex-col h-32 flex-wrap gap-2">
                    @foreach ($sessions as $timeKey => $timeValue)
                        <div class="flex items-center">
                            <input type="checkbox" id="session_{{ $timeKey }}___INDEX___" name="sessions[__INDEX__][]"
                                value="{{ $timeValue }}" class="mr-2">
                            <label for="session_{{ $timeKey }}___INDEX___"
                                class="text-sm text-gray-700">{{ $timeValue }}</label>
                        </div>
                    @endforeach
                </div>
                <p class="text-sm text-gray-500 mt-2">* Sesi dimulai dari jam genap (e.g., 08:00, 09:00).</p>
            </div>
        </div>
    </template>

    <!-- Script untuk Menambahkan dan Menghapus Date & Session -->
    <script>
        let dateSessionIndex = 1; // Mulai dari 1 karena grup pertama menggunakan index 0

        function addDateSession() {
            const container = document.getElementById('dates-container');
            const template = document.getElementById('date-session-template').innerHTML;

            // Replace __INDEX__ with current index
            const newGroup = template.replace(/__INDEX__/g, dateSessionIndex);

            // Replace ___INDEX___ in IDs
            const uniqueGroup = newGroup.replace(/___INDEX___/g, dateSessionIndex);

            container.insertAdjacentHTML('beforeend', uniqueGroup);
            dateSessionIndex++;
        }

        function removeDateSession(button) {
            const group = button.closest('.date-session-group');
            if (group) {
                group.remove();
            }
        }
    </script>
@endsection
