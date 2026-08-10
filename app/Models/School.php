<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
protected $fillable = [
        'name', 'group_type'
    ];

    public function schoolClasses()
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
