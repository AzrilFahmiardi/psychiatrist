<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'pasien_id', 
        'psikolog_id', 
        'jadwal_id', 
        'status_akses_layanan',
    ];
}
