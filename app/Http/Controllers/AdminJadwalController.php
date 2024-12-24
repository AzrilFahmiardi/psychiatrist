<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Psikolog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil parameter filter
        $psikolog_id = $request->input('psikolog_id');
        $week = $request->input('week');

        // Tentukan tanggal awal minggu (Senin)
        if ($week) {
            $startOfWeek = Carbon::parse($week)->startOfWeek();
        } else {
            $startOfWeek = Carbon::now()->startOfWeek();
        }

        // Tanggal akhir minggu (Jumat)
        $endOfWeek = $startOfWeek->copy()->addDays(4); // Senin + 4 hari = Jumat

        // Ambil jadwal sesuai filter
        $jadwalsQuery = Jadwal::with('psikolog', 'bookings')
            ->whereBetween('waktu', [$startOfWeek, $endOfWeek->endOfDay()]);

        if ($psikolog_id) {
            $jadwalsQuery->where('psikolog_id', $psikolog_id);
        }

        $jadwals = $jadwalsQuery->orderBy('waktu', 'asc')->get();

        // Group jadwals by day and time, simpan sebagai array
        $jadwalGrouped = [];
        foreach ($jadwals as $jadwal) {
            $day = $jadwal->waktu->format('Y-m-d');
            $time = $jadwal->waktu->format('H:i');
            $jadwalGrouped[$day][$time][] = $jadwal;
        }

        // Ambil semua psikolog untuk dropdown filter
        $psikologs = Psikolog::all();

        return view('admin.jadwals.index', compact('jadwalGrouped', 'psikologs', 'startOfWeek', 'endOfWeek', 'psikolog_id'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $psikologs = Psikolog::all();

        // Definisikan hari dalam seminggu
        $daysOfWeek = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        // Definisikan sesi yang tersedia (jam genap)
        $sessions = [];
        $currentHour = now()->timezone('Asia/Jakarta')->hour;
        $startHour = $currentHour + (2 - ($currentHour % 2));

        // Jika hasil perhitungan startHour kurang dari 8, tetapkan ke 8
        $startHour = 7;

        for ($hour = $startHour; $hour < 19; $hour += 1) {
            $time = Carbon::createFromTime($hour, 0)->format('H:i');
            $sessions[$time] = $time;
        }

        return view('admin.jadwals.create', compact('psikologs', 'daysOfWeek', 'sessions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'psikolog_id' => 'required|exists:psikologs,id',
            'dates' => 'required|array',
            'dates.*' => 'date|after_or_equal:today',
            'sessions' => 'required|array',
            'sessions.*' => 'array',
            'sessions.*.*' => 'in:' . implode(',', array_keys($this->getSessions())),
            'weeks' => 'required|integer|min:1|max:10',
        ]);

        $psikolog_id = $request->psikolog_id;
        $dates = $request->dates; // Array of dates
        $sessions = $request->sessions; // Array of sessions per date
        $weeks = $request->weeks;

        // Base date (mulai dari minggu depan) dengan timezone Asia/Jakarta
        $baseDate = Carbon::now()
            ->setTimezone('Asia/Jakarta')
            ->startOfWeek()
            ->addWeek();

        for ($week = 0; $week < $weeks; $week++) {
            foreach ($dates as $index => $date) {
                // Validasi hari (Senin-Jumat) dengan timezone Asia/Jakarta
                $carbonDate = Carbon::parse($date)->setTimezone('Asia/Jakarta');
                if (!$carbonDate->isWeekday() || in_array($carbonDate->dayOfWeekIso, [6, 7])) {
                    continue; // Skip non-Monday-Friday
                }

                // Tambahkan minggu ke tanggal
                $currentWeekDate = $carbonDate->copy()->addWeeks($week);

                foreach ($sessions[$index] as $session) {
                    // Buat datetime kombinasi tanggal dan sesi dengan timezone Asia/Jakarta
                    $waktu = Carbon::createFromFormat(
                        'Y-m-d H:i',
                        $currentWeekDate->format('Y-m-d') . ' ' . $session,
                        'Asia/Jakarta'
                    );

                    // Buat jadwal
                    Jadwal::create([
                        'waktu' => $waktu,
                        'psikolog_id' => $psikolog_id,
                        'status' => 'available',
                    ]);
                }
            }
        }

        return redirect()->route('admin.jadwals.index')
            ->with('success', 'Jadwal berhasil dibuat.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        $bookeds = $jadwal->bookings;

        if ($bookeds->count() > 0) {
            foreach ($bookeds as $booked) {
                $booked->status = 'rescheduled';
                $booked->save();
            }
        } else {
            $jadwal->delete();
        }

        return redirect()->route('admin.jadwals.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Helper function to get available sessions (jam genap).
     */
    private function getSessions()
    {
        $sessions = [];
        for ($hour = 0; $hour < 24; $hour += 1) {
            $time = Carbon::createFromTime($hour, 0)->format('H:i');
            $sessions[$time] = $time;
        }
        return $sessions;
    }
}
