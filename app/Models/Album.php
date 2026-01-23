<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'band_id',
        'title',
        'release_date',
        'image',
        'itunes_id',
        'itunes_url',
    ];

    public function band()
    {
        return $this->belongsTo(Band::class);
    }

    public function musics()
    {
        return $this->hasMany(Music::class);
    }
}
