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
        $jadwals = collect();
        $psikologs = Psikolog::all();
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
