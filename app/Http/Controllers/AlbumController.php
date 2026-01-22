<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlbumController extends Controller
{
    public function create()
    {
        return view('albums.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'  => 'required|string',
            'artist'=> 'required|string',
            'year'  => 'nullable|integer',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('image', 'public');
        }

        Album::create($data);

        return redirect('/music')->with('success', 'Álbum criado!');
    }

    public function edit(Album $album)
    {
        return view('albums.form', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate([
            'title'  => 'required|string',
            'artist'=> 'required|string',
            'year'  => 'nullable|digits:4',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('image', 'public');
        }

        $album->update($data);

        return redirect('/music')->with('success', 'Álbum atualizado!');
    }

    public function showFromItunes($collectionId)
{
    $response = Http::get('https://itunes.apple.com/lookup', [
        'id' => $collectionId,
        'entity' => 'song'
    ]);

    $results = $response->json()['results'] ?? [];

    $album = array_shift($results); // primeiro é o álbum
    $songs = $results; // resto são músicas

    return view('admin.album-songs', compact('album', 'songs'));
}

}
