<?php

namespace App\Models;

use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $fillable = ['name'];

    public function programStudis()
    {
        return $this->hasMany(ProgramStudi::class, 'departemen_id', 'id');
    }
}
