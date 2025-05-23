<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'nama_lengkap',
        'semester',
        'usia',
        'departemen',
        'program_studi',
        'jenis_kelamin',
        'no_hp',
        'status_akses_layanan',
        'role',
        'trial_left',
        'google_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function psikolog()
    {
        return $this->hasOne(Psikolog::class, 'user_id', 'id');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi', 'id');
    }
    public function getDepartemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'pasien_id');
    }
}
