<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeQuestion extends Model
{
    protected $fillable = [
        'question_text',
        'options',
        'correct_option',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];
}
