<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Psikolog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class JadwalController extends Controller
{
    public function index()
{
    // Memeriksa apakah pengguna sedang login
    if (Auth::check()) {
        // Jika login, ambil data user
        $user = Auth::user();
        // Ambil booking terakhir dari user yang login
        $bookingLastest = Booking::where('pasien_id', $user->id)->latest('created_at')->first();
    } else {
        // Jika tidak login, set bookingLastest menjadi null
        $bookingLastest = null;
    }

    // Ambil jadwal hari ini
    $today = now()->toDateString(); // Mendapatkan tanggal hari ini dalam format 'YYYY-MM-DD'
    $jadwals = Jadwal::whereDate('waktu', $today)->get(); // Filter jadwal berdasarkan tanggal hari ini
    $psikologs = Psikolog::all(); // Mendapatkan semua data psikolog

    return view('home', compact('jadwals', 'psikologs', 'bookingLastest'));
}
    
public function filterJadwal(Request $request)
{
    // Memeriksa apakah pengguna sedang login
    if (Auth::check()) {
        // Jika login, ambil data user
        $user = Auth::user();
        // Ambil booking terakhir dari user yang login
        $bookingLastest = Booking::where('pasien_id', $user->id)->latest('created_at')->first();
    } else {
        // Jika tidak login, set bookingLastest menjadi null
        $bookingLastest = null;
    }

    // Membuat query untuk filter jadwal
    $query = Jadwal::with('psikolog');
    
    if ($request->filled('psikolog')) {
        $query->where('psikolog_id', $request->psikolog);
    }
    
    if ($request->filled('tanggal')) {
        $query->whereDate('waktu', Carbon::parse($request->tanggal)->format('Y-m-d'));
    }

    $jadwals = $query->get();
    $psikologs = Psikolog::all();

    return view('home', compact('jadwals', 'psikologs', 'bookingLastest'));
}
}
