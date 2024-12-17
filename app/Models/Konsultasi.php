<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $fillable = [
        'booking_id', 
        'hasil_konsultasi',
    ];
}
