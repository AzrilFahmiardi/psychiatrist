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
    public function index()
    {
        // Memeriksa apakah pengguna sedang login
        if (Auth::check()) {
            // Jika login, ambil data user
            $user = Auth::user();
            
            // Ambil booking terakhir dari user yang login
            $bookingLastest = Booking::where('pasien_id', $user->id)->latest('created_at')->first();
            
            // Cek jika ada booking terakhir
            if ($bookingLastest) {
                // Ambil konsultasi terkait dengan booking terakhir
                $konsultasi = Konsultasi::all()->first();
            } else {
                // Jika tidak ada booking terakhir, set konsultasi null
                $konsultasi = null;
            }
        } else {
            // Jika tidak login, set bookingLastest dan konsultasi menjadi null
            $bookingLastest = null;
            $konsultasi = null;
        }
    
        // Ambil jadwal hari ini
        $today = now()->toDateString(); // Mendapatkan tanggal hari ini dalam format 'YYYY-MM-DD'
        $jadwals = Jadwal::whereDate('waktu', $today)->get(); // Filter jadwal berdasarkan tanggal hari ini
        
        // Mengambil semua data psikolog
        $psikologs = Psikolog::all();
    
        // Mengembalikan tampilan dengan data yang diperlukan
        return view('home', compact('jadwals', 'psikologs', 'bookingLastest', 'konsultasi'));
    }
    

public function filterJadwal(Request $request)
{
    // Memeriksa apakah pengguna sedang login
    if (Auth::check()) {
        // Jika login, ambil data user
        $user = Auth::user();
        
        // Ambil booking terakhir dari user yang login
        $bookingLastest = Booking::where('pasien_id', $user->id)->latest('created_at')->first();
        
        // Cek jika ada booking yang ditemukan
        if ($bookingLastest) {
            // Ambil konsultasi terkait dengan booking terakhir
            $konsultasi = Konsultasi::all()->first();
        } else {
            // Jika tidak ada booking terakhir, set konsultasi null
            $konsultasi = null;
        }
        
    } else {
        // Jika tidak login, set bookingLastest dan konsultasi menjadi null
        $bookingLastest = null;
        $konsultasi = null;
    }

    // Membuat query untuk filter jadwal
    $query = Jadwal::with('psikolog');
    
    if ($request->filled('psikolog')) {
        $query->where('psikolog_id', $request->psikolog);
    }
    
    if ($request->filled('tanggal')) {
        $query->whereDate('waktu', Carbon::parse($request->tanggal)->format('Y-m-d'));
    }

    // Mengambil jadwal yang difilter
    $jadwals = $query->get();
    
    // Mengambil semua psikolog
    $psikologs = Psikolog::all();

    // Mengembalikan tampilan dengan data yang diperlukan
    return view('home', compact('jadwals', 'psikologs', 'bookingLastest', 'konsultasi'));
}
}
