<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = [
        'school_id', 'name'
    ];

    // Relasi Balik ke Master Sekolah
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Relasi 1:N ke Siswa (Satu kelas berisi banyak siswa)
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
