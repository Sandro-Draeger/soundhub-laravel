<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Band;
use App\Models\Album;

class ItunesController extends Controller
{
    /**
     * Mostra a página de busca de artistas/álbuns
     */
    public function searchPage()
    {
        return view('itunes.search');
    }

    /**
     * Busca artistas na API do iTunes (para AJAX)
     */
    public function search(Request $request)
    {
        $term = $request->input('term');

        if (!$term || strlen($term) < 2) {
            return response()->json(['results' => []]);
        }

        $response = Http::get('https://itunes.apple.com/search', [
            'term' => $term,
            'entity' => 'artist,album',
            'limit' => 20
        ]);

        return response()->json(
            $response->json()['results'] ?? []
        );
    }

    /**
     * Busca resultados e mostra na página
     */
    public function results(Request $request)
    {
        $term = $request->input('term');
        $type = $request->input('type', 'artist'); // artist or album

        if (!$term || strlen($term) < 2) {
            return redirect()->route('itunes.search')->with('error', 'Digite algo para pesquisar');
        }

        $response = Http::get('https://itunes.apple.com/search', [
            'term' => $term,
            'entity' => $type,
            'limit' => 50
        ]);

        $results = $response->json()['results'] ?? [];

        return view('itunes.results', compact('results', 'term', 'type'));
    }

    /**
     * Mostra detalhes de um artista/álbum da API
     */
    public function show($collectionId)
    {
        // Busca detalhes do álbum e suas músicas
        $response = Http::get('https://itunes.apple.com/lookup', [
            'id' => $collectionId,
            'entity' => 'song'
        ]);

        $results = $response->json()['results'] ?? [];

        if (empty($results)) {
            return redirect()->route('itunes.search')->with('error', 'Álbum não encontrado');
        }

        $album = array_shift($results); // primeiro é o álbum
        $songs = $results; // resto são músicas

        return view('itunes.album-detail', compact('album', 'songs', 'collectionId'));
    }

    /**
     * Importa um artista/banda da API para o banco de dados
     */
    public function importArtist(Request $request)
    {
        // Apenas admins podem importar
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Apenas administradores podem importar artistas.');
        }

        $artistName = $request->input('artist_name');
        $artistPhoto = $request->input('artist_photo');

        // Verifica se a banda já existe
        $band = Band::where('name', $artistName)->first();

        if ($band) {
            return back()->with('error', 'Esta banda já existe no banco de dados.');
        }

        // Cria nova banda
        $band = Band::create([
            'name' => $artistName,
            'photo' => null // Poderia salvar a foto da API aqui
        ]);

        return back()->with('success', 'Banda "' . $artistName . '" importada com sucesso!');
    }

    /**
     * Importa um álbum da API para o banco de dados
     */
    public function importAlbum(Request $request)
    {
        // Apenas admins podem importar
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Apenas administradores podem importar álbuns.');
        }

        $request->validate([
            'band_id' => 'required|exists:bands,id',
            'album_name' => 'required|string',
            'release_date' => 'nullable|date',
            'album_art' => 'nullable|image|max:2048',
            'itunes_id' => 'nullable|string',
        ]);

        // Verifica se o álbum já existe
        $album = Album::where('title', $request->input('album_name'))->first();

        if ($album) {
            return back()->with('error', 'Este álbum já existe no banco de dados.');
        }

        $data = [
            'band_id' => $request->input('band_id'),
            'title' => $request->input('album_name'),
            'release_date' => $request->input('release_date'),
            'itunes_id' => $request->input('itunes_id'),
        ];

        // Salva imagem se fornecida
        if ($request->hasFile('album_art')) {
            $data['image'] = $request->file('album_art')->store('albums', 'public');
        }

        Album::create($data);

        return back()->with('success', 'Álbum "' . $request->input('album_name') . '" importado com sucesso!');
    }
}
