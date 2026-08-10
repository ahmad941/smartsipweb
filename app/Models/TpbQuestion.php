<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpbQuestion extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'construct_type', 'question_text', 'is_active'
    ];

    // Relasi 1:N ke Jawaban (Satu soal dijawab oleh banyak siswa pada berbagai fase)
    public function tpbResponses()
    {
        return $this->hasMany(TpbResponse::class, 'question_id');
    }
}
