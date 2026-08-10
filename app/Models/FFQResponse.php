<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FFQResponse extends Model
{
    protected $table = 'ffq_responses';

    protected $fillable = [
        'student_id',
        'phase',
        'items_data',
        'total_daily_sugar_grams',
        'category',
        'answered_at',
    ];

    protected $casts = [
        'items_data' => 'array',
        'answered_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
