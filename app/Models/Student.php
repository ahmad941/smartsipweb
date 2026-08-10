<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id', 'informed_consent', 'school_id', 'class_id', 'nickname', 'gender', 
        'date_of_birth', 'height_cm', 'weight_kg', 'bmi_score', 'body_fat_percentage',
        'pocket_money', 'father_education', 'mother_education'
    ];

    // Relasi Balik ke Akun Induk
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi 1:N ke Jawaban Kuesioner TPB
    public function tpbResponses()
    {
        return $this->hasMany(TpbResponse::class);
    }

    public function ffqResponses()
    {
        return $this->hasMany(FFQResponse::class);
    }

    public function knowledgeResponses()
    {
        return $this->hasMany(KnowledgeResponse::class);
    }

    public function usabilityResponses()
    {
        return $this->hasMany(UsabilityResponse::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // Kalkulasi Usia Otomatis (Accessor)
    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['date_of_birth'])->age;
    }
}
