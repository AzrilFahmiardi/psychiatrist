<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Psikolog;
use Illuminate\Http\Request;


class JadwalController extends Controller
{
    public function index()
    {
        $today = now()->toDateString(); // Mendapatkan tanggal hari ini dalam format 'YYYY-MM-DD'
        $jadwals = Jadwal::whereDate('waktu', $today)->get(); // Filter jadwal berdasarkan tanggal hari ini
        $psikologs = Psikolog::all(); // Mendapatkan semua data psikolog
        return view('home', compact('jadwals', 'psikologs'));
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
        return view('home', compact('jadwals', 'psikologs'));
    }
}
