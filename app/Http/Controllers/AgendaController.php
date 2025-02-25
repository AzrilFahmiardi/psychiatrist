<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Booking;
use App\Models\Konsultasi;
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
        $today = Carbon::now('Asia/Jakarta'); // Tanggal sekarang
        $startOfWeek = $today->copy()->startOfWeek(Carbon::MONDAY); // Mulai dari Senin minggu ini
        $endOfWeek = $today->copy()->endOfWeek(Carbon::SUNDAY); // Berakhir di Minggu minggu ini
    
        $bookings = Booking::where('psikolog_id', Auth::id())
                           ->where('status', '!=', 'completed')
                           ->get();
    
        // Mengambil jadwal antara Senin minggu ini hingga Minggu minggu ini
        $jadwals = Jadwal::where('psikolog_id', Auth::id())
                         ->whereBetween('waktu', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
                         ->get();
        
        $completes = Booking::where('psikolog_id', Auth::id())
                           ->where('status', 'completed') 
                           ->get();
        
        return view('agenda', compact('jadwals', 'bookings', 'completes'));
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
        $jadwals = Jadwal::where('psikolog_id', Auth::id()) // Filter berdasarkan psikolog yang sedang login
                    ->whereBetween('waktu', [
                        $startDate->copy()->startOfDay(),
                        $endDate->copy()->endOfDay()
                    ])
                    ->with('pasien') // Memuat relasi pasien
                    ->get();

        $bookings = Booking::where('psikolog_id', Auth::id())
        ->where('status', '!=', 'completed')
        ->get();

        $completes = Booking::where('psikolog_id', Auth::id())
                           ->where('status', 'completed') 
                           ->get();

        // dd($jadwals);


        return view('agenda', compact('jadwals', 'bookings','completes'));
    }

    public function addKonsultasi(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'hasil_konsultasi' => 'required|string'
        ]);

        // Update booking status to completed
        $booking = Booking::findOrFail($validated['booking_id']);
        $booking->update(['status' => 'completed']);

        Konsultasi::create($validated);

        return redirect()->back()->with('success', 'Hasil konsultasi berhasil disimpan');
    }

    public function updateKonsultasi(Request $request)
    {
        $validated = $request->validate([
            'konsultasi_id' => 'required|exists:konsultasis,id',
            'hasil_konsultasi' => 'required|string'
        ]);

        $konsultasi = Konsultasi::findOrFail($validated['konsultasi_id']);
        $konsultasi->update([
            'hasil_konsultasi' => $validated['hasil_konsultasi']
        ]);

        return redirect()->back()->with('success', 'Hasil konsultasi berhasil diperbarui');
    }
}
