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
        'user_id',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'psikolog_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

