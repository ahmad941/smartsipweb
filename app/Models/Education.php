<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';

    protected $fillable = [
        'title', 'type', 'content', 'media_url', 'is_published'
    ];

    public function getEmbedUrlAttribute()
    {
        if (empty($this->media_url)) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->media_url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return $this->media_url;
    }
}
