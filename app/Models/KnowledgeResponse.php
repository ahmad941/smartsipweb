<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeResponse extends Model
{
    protected $fillable = [
        'student_id',
        'phase',
        'score',
        'category',
        'answers',
        'answered_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'answered_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
