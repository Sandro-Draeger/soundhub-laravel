<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $table = 'musics';

    protected $fillable = [
        'album_id',
        'track_name',
        'artist_name',
        'track_time',
        'preview_url',
        'itunes_id',
        'itunes_url',
    ];

    public function album() {
        return $this->belongsTo(Album::class);
    }
}
