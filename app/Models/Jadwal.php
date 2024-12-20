<?php

namespace App\Models;

use App\Models\Psikolog;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'waktu',
        'status',
        'psikolog_id',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function psikolog()
    {
        return $this->belongsTo(Psikolog::class, 'psikolog_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'jadwal_id', 'id');
    }

    public function pasien()
    {
        return $this->hasManyThrough(
            User::class,       // Model yang dituju
            Booking::class,    // Model perantara
            'jadwal_id',       // Foreign key di tabel Booking
            'id',              // Foreign key di tabel User
            'id',              // Local key di tabel Jadwal
            'pasien_id'        // Local key di tabel Booking
        );
    }
}
