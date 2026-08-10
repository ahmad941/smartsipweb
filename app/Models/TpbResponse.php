<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpbResponse extends Model
{
   protected $fillable = [
        'student_id', 'question_id', 'phase', 'score', 'answered_at'
    ];

    // Relasi Balik ke Responden
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi Balik ke Master Pertanyaan
    public function question()
    {
        return $this->belongsTo(TpbQuestion::class);
    }
}
