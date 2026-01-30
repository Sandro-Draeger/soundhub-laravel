<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    // Lista playlists do usuário
    public function index()
    {
        $playlists = auth()->user()->playlists()->with('musics')->get() ?? [];
        return view('playlists.index', compact('playlists'));
    }

    // Cria nova playlist
    public function create()
    {
        return view('playlists.create');
    }

    // Salva playlist
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);
        $playlist = auth()->user()->playlists()->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        return redirect()->route('playlists.show', $playlist)->with('success', 'Playlist criada!');
    }

    // Mostra uma playlist
    public function show(Playlist $playlist)
    {
        if ($playlist->user_id !== auth()->id()) {
            abort(403);
        }
        $musics = $playlist->musics;
        return view('playlists.show', compact('playlist', 'musics'));
    }

    // Edita playlist
    public function edit(Playlist $playlist)
    {
        if ($playlist->user_id !== auth()->id()) {
            abort(403);
        }
        return view('playlists.edit', compact('playlist'));
    }

    // Atualiza playlist
    public function update(Request $request, Playlist $playlist)
    {
        if ($playlist->user_id !== auth()->id()) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);
        $playlist->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        return redirect()->route('playlists.show', $playlist)->with('success', 'Playlist atualizada!');
    }

    // Remove playlist
    public function destroy(Playlist $playlist)
    {
        if ($playlist->user_id !== auth()->id()) {
            abort(403);
        }
        $playlist->delete();
        return redirect()->route('playlists.index')->with('success', 'Playlist removida!');
    }

    // Adiciona música à playlist
    public function addSong(Request $request)
    {
        $request->validate([
            'playlist_id' => 'required|exists:playlists,id',
            'track_name'  => 'required|string',
            'preview_url' => 'nullable|string',
            'album_id'    => 'required|exists:albums,id',
            'artist_name' => 'required|string',
        ]);
        $playlist = Playlist::where('id', $request->playlist_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $playlist->musics()->create([
            'track_name'  => $request->track_name,
            'preview_url' => $request->preview_url,
            'album_id'    => $request->album_id,
            'artist_name' => $request->artist_name,
        ]);
        return back()->with('success', 'Song added to your playlist!');
    }

    public function removeMusic(Request $request)
    {
        $request->validate([
            'playlist_id' => 'required|exists:playlists,id',
            'music_id'    => 'required|exists:musics,id',
        ]);
        $playlist = Playlist::where('id', $request->playlist_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $music = $playlist->musics()->where('musics.id', $request->music_id)->firstOrFail();
        $playlist->musics()->detach($music->id);
        return back()->with('success', 'Song removed from your playlist!');
    }
}
