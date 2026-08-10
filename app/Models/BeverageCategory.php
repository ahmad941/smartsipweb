<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeverageCategory extends Model
{
    protected $fillable = [
        'name'
    ];

    // Relasi 1:N ke Minuman (Satu kategori menaungi banyak minuman)
    public function beverages()
    {
        return $this->hasMany(Beverage::class, 'category_id');
    }
}
