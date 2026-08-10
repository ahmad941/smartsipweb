<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsabilityResponse extends Model
{
    protected $fillable = [
        'student_id',
        'scores',
        'total_score',
        'category',
        'answered_at',
    ];

    protected $casts = [
        'scores' => 'array',
        'answered_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
