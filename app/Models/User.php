<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
   use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'google_id', 'role', 'school_id', 'avatar_url',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relasi 1:1 ke Profil Spesifik Siswa (Responden)
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    // Relasi 1:N ke Catatan Konsumsi Gula
    public function sugarConsumptions()
    {
        return $this->hasMany(SugarConsumption::class);
    }

    // Relasi 1:N ke Riwayat Poin Gamifikasi
    public function pointHistories()
    {
        return $this->hasMany(PointHistory::class);
    }
}
