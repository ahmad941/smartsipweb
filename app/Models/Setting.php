<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public const CREATED_AT = null;

    protected $fillable = [
        'key', 'value'
    ];
}
