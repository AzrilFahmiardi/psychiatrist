<?php

namespace App\Models;

use App\Models\Psikolog;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'waktu',
        'status'
    ];

    public function psikolog()
    {
        return $this->belongsTo(Psikolog::class, 'psikolog_id', 'id');
    }
}
