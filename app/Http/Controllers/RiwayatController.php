<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    function getBooking()
    {
        $bookings = Booking::with(['psikolog', 'jadwal', 'konsultasi'])
            ->where('pasien_id', Auth::id())
            ->get();

        return view('riwayat', compact('bookings'));
    }
}
