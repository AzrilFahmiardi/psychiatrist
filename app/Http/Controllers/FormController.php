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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // Ambil data sesi dan user
        $jadwalId = session('selected_jadwal_id');
        $psikologId = session('selected_psikolog_id');
        $user = Auth::user();
        $trial = $user->trial_left;

        try {
            // Cek apakah jadwal sudah dibooking
            $existingBooking = Booking::where('jadwal_id', $jadwalId)->first();
            if ($existingBooking) {
                return redirect()->route('home')->with('error', 'Jadwal sudah dibooking. Silakan pilih jadwal lain.');
            }

            // Buat booking baru
            $booking = new Booking();
            $booking->pasien_id = $user->id;
            $booking->jadwal_id = $jadwalId;
            $booking->psikolog_id = $psikologId;
            $booking->status_akses_layanan = 'submitted';

            // Jika trial habis, wajib upload bukti pembayaran
            if ($trial <= 0) {
                // Validasi input
                $request->validate([
                    'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                ]);

                // Simpan file bukti pembayaran
                $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
                $booking->bukti_pembayaran = $buktiPath;
                $booking->status_akses_layanan = 'scheduled';
            }

            // Simpan booking
            $booking->save();

            // Update status jadwal menjadi 'booked'
            DB::table('jadwals')->where('id', $jadwalId)->update(['status' => 'booked']);

            // Kurangi trial_left jika masih memiliki trial
            if ($trial > 0) {
                User::where('id', $user->id)->decrement('trial_left');
            }

            // Hapus sesi
            session()->forget(['selected_jadwal_id', 'selected_psikolog_id']);

            return redirect()->route('home')->with('success', 'Jadwal berhasil terboking.');
        } catch (\Exception $e) {
            // Log error
            return redirect()->back()->with('error', 'Gagal membuat booking. Silakan coba lagi.');
        }
    }
}
