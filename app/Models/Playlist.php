<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Song;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'photo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function musics()
    {
        return $this->belongsToMany(Song::class, 'playlist_music', 'playlist_id', 'music_id')
            ->withPivot('order')
            ->orderBy('playlist_music.order');
    }
}
