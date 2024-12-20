<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    function homePsikolog() {
        $bookings = Booking::where('psikolog_id', Auth::id())
                           ->where('status', '!=', 'completed') // Filter status
                           ->latest('created_at')               // Urutkan dari yang terbaru berdasarkan created_at
                           ->take(3)                            // Ambil 3 data saja
                           ->get();
    
        return view('home-psikolog', compact('bookings'));
    }

    function agendaPsikolog(){
        $today = Carbon::now('Asia/Jakarta'); // Mendapatkan tanggal hari ini
        $endDate = $today->copy()->addDays(7); // Mendapatkan tanggal 7 hari ke depan
        
        $bookings = Booking::where('psikolog_id', Auth::id())
                           ->where('status', '!=', 'completed')
                           ->get();

        // Mengambil jadwal antara tanggal hari ini dan 7 hari ke depan
        $jadwals = Jadwal::where('psikolog_id', Auth::id())
                         ->whereBetween('waktu', [$today->toDateString(), $endDate->toDateString()])
                         ->get();
    
        return view('agenda', compact('jadwals', 'bookings'));
    }
    
    function agendaPsikologFilterJadwal(Request $request){
        $weekOffset = intval($request->input('week_offset', 0));
    
        // Get start of week (Monday)
        $startDate = Carbon::now('Asia/Jakarta')
            ->startOfWeek()
            ->addWeeks($weekOffset);
        
        // End of week (Sunday)
        $endDate = $startDate->copy()->addDays(6);

        // Fetch schedules for the week
        $jadwals = Jadwal::whereBetween('waktu', [
            $startDate->copy()->startOfDay(),
            $endDate->copy()->endOfDay()
        ])
        ->with('pasien')
        ->get();

        $bookings = Booking::where('psikolog_id', Auth::id())
        ->where('status', '!=', 'completed')
        ->get();

        return view('agenda', compact('jadwals', 'bookings'));
    }
}
