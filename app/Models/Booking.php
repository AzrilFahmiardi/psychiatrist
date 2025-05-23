<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'pasien_id', 
        'psikolog_id', 
        'jadwal_id', 
        'status',
        'google_calendar_event_id',
        'bukti_pembayaran',
    ];

    public function psikolog()
    {
        return $this->belongsTo(Psikolog::class);
    }
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }
    public function konsultasi()
    {
        return $this->hasOne(Konsultasi::class);
    }
}
