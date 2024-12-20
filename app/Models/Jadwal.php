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
}
