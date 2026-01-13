<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Konsultasi;
use App\Models\Psikolog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class JadwalController extends Controller
{
    /**
     * Display the home page with today's schedule
     */
    public function index()
    {
        $bookingLastest = null;
        $konsultasi = null;

        if (Auth::check()) {
            $bookingLastest = Booking::where('pasien_id', Auth::id())
                ->latest('created_at')
                ->first();
            
            if ($bookingLastest) {
                $konsultasi = Konsultasi::orderBy('created_at', 'desc')->first();
            }
        }
    
        $today = Carbon::now('Asia/Jakarta')->toDateString();
        $jadwals = Jadwal::whereDate('waktu', $today)->get();
        $psikologs = Psikolog::all();
    
        return view('home', compact('jadwals', 'psikologs', 'bookingLastest', 'konsultasi'));
    }
    

    /**
     * Filter schedule by psikolog and date
     */
    public function filterJadwal(Request $request)
    {
        $bookingLastest = null;
        $konsultasi = null;

        if (Auth::check()) {
            $bookingLastest = Booking::where('pasien_id', Auth::id())
                ->latest('created_at')
                ->first();
            
            if ($bookingLastest) {
                $konsultasi = Konsultasi::orderBy('created_at', 'desc')->first();
            }
        }

        $query = Jadwal::with('psikolog');
    
        if ($request->filled('psikolog') && $request->psikolog != 'none') {
            $query->where('psikolog_id', $request->psikolog);
        }
        
        if ($request->filled('tanggal')) {
            $query->whereDate('waktu', Carbon::parse($request->tanggal)->format('Y-m-d'));
        }

        $jadwals = $query->get();
        $psikologs = Psikolog::all();
        $selectedPsikolog = $request->psikolog;

        return view('home', compact('jadwals', 'psikologs', 'bookingLastest', 'konsultasi', 'selectedPsikolog'));
    }
}
