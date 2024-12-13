<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $fillable = ['name', 'departemen_id'];

    // Relasi ke Departemen
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id', 'id');
    }
}
