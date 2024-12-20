<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Psikolog;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $psikologs = Psikolog::all();
        $selectedPsikolog = $request->psikolog_id;
        $selectedStatus = $request->status ?? 'scheduled';

        $bookings = Booking::with(['psikolog', 'pasien', 'jadwal'])
            ->when($selectedPsikolog, function($query) use ($selectedPsikolog) {
                return $query->where('psikolog_id', $selectedPsikolog);
            })
            ->where('status_akses_layanan', $selectedStatus)
            ->latest()
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings', 'psikologs', 'selectedPsikolog', 'selectedStatus'));
    }

    public function edit(Booking $booking)
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status_akses_layanan' => 'required|in:submitted,scheduled,completed,rescheduled,cancel',
        ]);

        $booking->update([
            'status_akses_layanan' => $request->status_akses_layanan,
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Status booking berhasil diperbarui.');
    }
}
