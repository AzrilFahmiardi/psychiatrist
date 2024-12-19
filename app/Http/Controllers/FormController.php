<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Form;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Booking;
use App\Models\Psikolog;
use App\Models\Departemen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Google\Client;
use Google\Service\Calendar;

class FormController extends Controller
{
    function persetujuan()
    {
        return view('form.persetujuan');
    }

    function data_diri()
    {
        $email = Auth::user()->email;
        $user = User::where('email', $email)->first();

        $departemen = Departemen::all();
        
        $prodi = ProgramStudi::all();


        return view('form.data_diri', compact('user', 'departemen', 'prodi'));
    }

    function pilih_jadwal()
    {
        $today = now()->toDateString(); // Mendapatkan tanggal hari ini dalam format 'YYYY-MM-DD'
        $jadwals = Jadwal::whereDate('waktu', $today)->get(); // Filter jadwal berdasarkan tanggal hari ini
        $psikologs = Psikolog::all(); // Mendapatkan semua data psikolog
        return view('form.pilih_jadwal', compact('jadwals', 'psikologs'));
    }

    public function filterJadwal(Request $request)
    {
        $query = Jadwal::with('psikolog');
    
        if ($request->filled('psikolog')) {
            $query->where('psikolog_id', $request->psikolog);
        }
    
        if ($request->filled('tanggal')) {
            $query->whereDate('waktu', Carbon::parse($request->tanggal)->format('Y-m-d'));
        }
    
        $jadwals = $query->get();
        $psikologs = Psikolog::all();
        return view('form.pilih_jadwal', compact('jadwals', 'psikologs'));
    }

    function ketentuan_submit(Request $request)
    {
        $jadwalId = $request->input('jadwal_id') ?? session('selected_jadwal_id');
        $psikologId = $request->input('psikolog_id') ?? session('selected_psikolog_id');

        // If no IDs are found, redirect back to schedule selection
        if (!$jadwalId || !$psikologId) {
            return redirect()->route('form.pilih_jadwal')->with('error', 'Silakan pilih jadwal terlebih dahulu.');
        }

        // Store in session again to maintain state
        session([
            'selected_jadwal_id' => $jadwalId,
            'selected_psikolog_id' => $psikologId
        ]);

        return view('form.ketentuan_submit', compact('jadwalId', 'psikologId'));
    }

    function pembayaran()
    {
        $jadwalId = session('selected_jadwal_id');
        $psikologId = session('selected_psikolog_id');

        // If no IDs are found, redirect back to schedule selection
        if (!$jadwalId || !$psikologId) {
            return redirect()->route('form.pilih_jadwal')->with('error', 'Silakan pilih jadwal terlebih dahulu.');
        }

        return view('form.pembayaran', compact('jadwalId', 'psikologId'));
    }

    function simpan_booking(Request $request)
    {
        // KUMPULIN DATA
        $jadwalId = session('selected_jadwal_id');
        $psikologId = session('selected_psikolog_id');
        $user = Auth::user();
        $token = json_decode($user->google_token, true);
        $trial = $user->trial_left;
        $currentDate = Carbon::now();  // Ambil waktu sekarang
        $oneWeekAgo = $currentDate->copy()->subDays(7);  // Salin objek dan kurangi 7 hari


        try {
            // CEK JUMLAH BOOKING USER
            $bookingCount = Booking::where('pasien_id', $user->id)
                ->whereBetween('created_at', [$oneWeekAgo, $currentDate])
                ->count();

            if ($bookingCount >= 2) {
                return redirect()->route('home')->with('error', 'Anda hanya dapat memesan maksimal 2 kali dalam seminggu.');
            }

            $existingBooking = Booking::where('jadwal_id', $jadwalId)->first();
            if ($existingBooking) {
                return redirect()->route('home')->with('error', 'Jadwal sudah dibooking. Silakan pilih jadwal lain.');
            }

            // INSERT DATA
            $booking = new Booking();
            $booking->pasien_id = $user->id;
            $booking->jadwal_id = $jadwalId;
            $booking->psikolog_id = $psikologId;
            $booking->status_akses_layanan = 'submitted';

            // CEK TRIAL
            if ($trial <= 0) {
                $request->validate([
                    'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                ]);

                $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
                $booking->bukti_pembayaran = $buktiPath;
                $booking->status_akses_layanan = 'scheduled';
            }

            $booking->save();

            // ADD TO GOOGLE CALENDAR
            $client = new Client();
    $client->setClientId(config('services.google.client_id'));
    $client->setClientSecret(config('services.google.client_secret'));
    $client->setAccessType('offline');        

    // Set token yang tersimpan
    $token = json_decode($user->google_token, true);
    $client->setAccessToken($token);

    // Cek jika token expired
    if ($client->isAccessTokenExpired()) {
        if (isset($token['refresh_token'])) {
            $newToken = $client->fetchAccessTokenWithRefreshToken($token['refresh_token']);
            
            // Simpan token baru
            $user->google_token = json_encode($newToken);
            $user->save();
        } else {
            throw new \Exception('Refresh token tidak tersedia. Silakan login ulang.');
        }
    }

    $service = new Calendar($client);
    $dokter = Psikolog::where('id', $psikologId)->first();
    $waktu = Jadwal::where('id', $jadwalId)->first();
    
    $carbonWaktu = Carbon::parse($waktu->waktu);
    
    $event = new Calendar\Event([
        'summary' => "Konsultasi dengan {$dokter->name}",
        'description' => "Konsultasi Psikologi di UGM Medical Center",
        'location' => 'UGM Medical Center',
        'start' => [
            'dateTime' => $carbonWaktu->toIso8601String(),
            'timeZone' => 'Asia/Jakarta',
        ],
        'end' => [
            'dateTime' => $carbonWaktu->copy()->addHour()->toIso8601String(),
            'timeZone' => 'Asia/Jakarta',
        ],
        'reminders' => [
            'useDefault' => false,
            'overrides' => [
                ['method' => 'email', 'minutes' => 24 * 60], // reminder 1 hari sebelumnya
                ['method' => 'popup', 'minutes' => 30], // reminder 30 menit sebelumnya
            ],
        ],
    ]);

    // Tambahkan event ke kalender
    $createdEvent = $service->events->insert('primary', $event);
    
    // Simpan ID event Google Calendar ke database (opsional)
    // $booking->google_calendar_event_id = $createdEvent->id;

            


            // UPDATE VARIABEL

            DB::table('jadwals')->where('id', $jadwalId)->update(['status' => 'booked']);

            if ($trial > 0) {
                User::where('id', $user->id)->decrement('trial_left');
            }

            session()->forget(['selected_jadwal_id', 'selected_psikolog_id']);

            return redirect()->route('home')->with('success', 'Jadwal berhasil terboking.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Gagal membuat booking. Silakan coba lagi.');
        }
    }
}
