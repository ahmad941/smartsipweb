<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchTeam extends Model
{
    protected $fillable = [
        'name', 'role', 'institution', 'photo_url', 'description', 'sort_order'
    ];
}
