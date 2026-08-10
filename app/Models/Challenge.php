<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'title', 'description', 'reward_points', 'is_active'
    ];

    // Relasi 1:N ke Riwayat Poin
    public function pointHistories()
    {
        return $this->hasMany(PointHistory::class);
    }
}
