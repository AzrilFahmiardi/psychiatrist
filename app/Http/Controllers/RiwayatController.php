<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    function getBooking()
{
    $bookings = Booking::with(['psikolog', 'jadwal', 'konsultasi'])->get();

    return view('riwayat', compact('bookings'));
}
    
}
