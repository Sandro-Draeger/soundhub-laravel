<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Band;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('band', 'songs')->get();
        return view('albums.index', compact('albums'));
    }

    public function create()
    {
        $bands = Band::all();
        return view('albums.form', compact('bands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'band_id'      => 'required|exists:bands,id',
            'title'        => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('albums', 'public');
        }

        Album::create($data);

        return redirect()->route('albums.index')->with('success', 'Álbum criado com sucesso!');
    }

    public function show(Album $album)
    {
        return view('albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        $bands = Band::all();
        return view('albums.form', compact('album', 'bands'));
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate([
            'band_id'      => 'required|exists:bands,id',
            'title'        => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('albums', 'public');
        }

        $album->update($data);

        return redirect()->route('albums.index')->with('success', 'Álbum atualizado com sucesso!');
    }

    public function destroy(Album $album)
    {
        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Álbum removido com sucesso!');
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
