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
        $jadwalId = $request->input('jadwal_id');
        $psikologId = $request->input('psikolog_id');

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

        // Gunakan $jadwalId dan $psikologId untuk menyimpan ke tabel booking
        return view('form.pembayaran', compact('jadwalId', 'psikologId'));
    }

    function simpan_booking()
    {
        $jadwalId = session('selected_jadwal_id');
        $psikologId = session('selected_psikolog_id');
        $user = Auth::user();

        // Buat booking baru
        $booking = new Booking();
        $booking->pasien_id = $user->id;
        $booking->jadwal_id = $jadwalId;
        $booking->psikolog_id = $psikologId;
        $booking->save();

        // Kurangi trial_left jika masih memiliki trial
        User::where('id', $user->id)->decrement('trial_left');


        session()->forget(['selected_jadwal_id', 'selected_psikolog_id']);

        return redirect()->route('home')->with('success', 'Jadwal berhasil terboking');
    }
}
