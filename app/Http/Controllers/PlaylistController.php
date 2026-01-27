<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Music;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lista todas as playlists do usuário
     */
    public function index()
    {
        $playlists = auth()->user()->playlists ?? [];
        return view('playlists.index', compact('playlists'));
    }

    /**
     * Mostra formulário para criar nova playlist
     */
    public function create()
    {
        return view('playlists.create');
    }

    /**
     * Salva nova playlist
     */
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

        return redirect()->route('playlists.show', $playlist)->with('success', 'Playlist criada com sucesso!');
    }

    /**
     * Mostra uma playlist específica
     */
    public function show(Playlist $playlist)
    {
        // Verifica se o usuário tem permissão
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para visualizar esta playlist.');
        }

        $musics = $playlist->musics;
        return view('playlists.show', compact('playlist', 'musics'));
    }

    /**
     * Mostra formulário para editar playlist
     */
    public function edit(Playlist $playlist)
    {
        // Verifica se o usuário tem permissão
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para editar esta playlist.');
        }

        return view('playlists.edit', compact('playlist'));
    }

    /**
     * Atualiza playlist
     */
    public function update(Request $request, Playlist $playlist)
    {
        // Verifica se o usuário tem permissão
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para atualizar esta playlist.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $playlist->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('playlists.show', $playlist)->with('success', 'Playlist atualizada com sucesso!');
    }

    /**
     * Deleta playlist
     */
    public function destroy(Playlist $playlist)
    {
        // Verifica se o usuário tem permissão
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para deletar esta playlist.');
        }

        $playlist->delete();
        return redirect()->route('playlists.index')->with('success', 'Playlist removida com sucesso!');
    }

    /**
     * Adiciona música à playlist
     */
    public function addMusic(Request $request, Playlist $playlist)
    {
        // Verifica se o usuário tem permissão
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para modificar esta playlist.');
        }

        $request->validate([
            'music_id' => 'required|exists:musics,id',
        ]);

        $musicId = $request->input('music_id');

        // Verifica se a música já está na playlist
        if ($playlist->musics()->where('music_id', $musicId)->exists()) {
            return back()->with('error', 'Esta música já está na playlist.');
        }

        $playlist->musics()->attach($musicId, ['order' => $playlist->musics()->count() + 1]);

        return back()->with('success', 'Música adicionada à playlist!');
    }

    /**
     * Remove música da playlist
     */
    public function removeMusic(Request $request, Playlist $playlist)
    {
        // Verifica se o usuário tem permissão
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para modificar esta playlist.');
        }

        $request->validate([
            'music_id' => 'required|exists:musics,id',
        ]);

        $playlist->musics()->detach($request->input('music_id'));

        return back()->with('success', 'Música removida da playlist!');
    }
}
