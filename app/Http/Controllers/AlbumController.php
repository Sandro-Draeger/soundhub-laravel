<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Band;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlbumController extends Controller
{
    // Lista todos os álbuns
    public function index()
    {
        $albums = Album::with('band', 'songs')->get();
        return view('albums.index', compact('albums'));
    }

    // Mostra detalhes de um álbum
    public function show(Album $album)
    {
        return view('albums.show', compact('album'));
    }

    // Remove um álbum
    public function destroy(Album $album)
    {
        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Album removido com sucesso!');
    }
}
