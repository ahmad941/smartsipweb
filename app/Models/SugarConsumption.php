<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SugarConsumption extends Model
{
    protected $fillable = [
        'user_id', 'beverage_id', 'volume_ml', 'total_sugar_grams', 'consumed_at'
    ];

    // Relasi Balik ke Pengguna (Siapa yang minum)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Balik ke Minuman (Apa yang diminum)
    public function beverage()
    {
        return $this->belongsTo(Beverage::class);
    }
}
