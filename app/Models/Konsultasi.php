<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $fillable = [
        'booking_id', 
        'hasil_konsultasi',
    ];

    public function booking()
{
    return $this->belongsTo(Booking::class);
}

public function jadwal()
{
    return $this->belongsToThrough(Jadwal::class, Booking::class);
}

}
