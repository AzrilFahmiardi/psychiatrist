<?php

namespace App\Models;

use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Model;

class Psikolog extends Model
{
    protected $fillable = [
        'name',
        'nama_lengkap',
        'email',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'psikolog_id', 'id');
    }
}
