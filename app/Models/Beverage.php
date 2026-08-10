<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beverage extends Model
{
    protected $fillable = [
        'category_id', 'name', 'sugar_per_100ml', 'image_url'
    ];

    public function category()
    {
        return $this->belongsTo(BeverageCategory::class);
    }

    public function sugarConsumptions()
    {
        return $this->hasMany(SugarConsumption::class);
    }
}
