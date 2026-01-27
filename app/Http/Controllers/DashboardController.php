<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Models\Album;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Carrega apenas álbuns que têm band_id válido
        $albums = Album::whereNotNull('band_id')->with('band', 'songs')->get();

        return view('dashboard', compact('albums'));
    }

    public function showAlbum($id)
    {
        $album = Album::with('band', 'songs')->findOrFail($id);

        return view('dashboard.album', compact('album'));
    }

    public function destroyAlbum($id)
    {
        // Apenas admins podem deletar
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Apenas administradores podem remover álbuns.');
        }

        $album = Album::findOrFail($id);

        // Remove as músicas associadas
        $album->songs()->delete();

        // Remove o álbum
        $album->delete();

        return redirect()->route('dashboard')->with('success', 'Álbum removido com sucesso!');
    }

    public function manageSongs($id)
    {
        // Apenas admins podem gerenciar músicas
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Apenas administradores podem gerenciar músicas.');
        }

        $album = Album::with('band', 'songs')->findOrFail($id);

        return view('dashboard.manage-songs', compact('album'));
    }

    public function destroySong($albumId, $songId)
    {
        // Apenas admins podem remover músicas
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Apenas administradores podem remover músicas.');
        }

        $song = Song::findOrFail($songId);

        // Verificar se a música pertence ao álbum
        if ($song->album_id != $albumId) {
            abort(403, 'Esta música não pertence a este álbum.');
        }

        $song->delete();

        return redirect()->route('dashboard.album.manage-songs', $albumId)->with('success', 'Música removida com sucesso!');
    }

}

