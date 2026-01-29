<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Band;
use App\Models\Album;
use App\Models\Song;

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
        if (!Auth::check() || Auth::user()->role !== 'admin') {
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
            'photo' => $artistPhoto
        ]);

        return back()->with('success', 'Banda "' . $artistName . '" importada com sucesso!');
    }

    /**
     * Importa um álbum da API para o banco de dados
     */
    public function importAlbum(Request $request)
    {
        // Apenas admins podem importar
        if (!Auth::check() || Auth::user()->role !== 'admin') {

        }

        $request->validate([
            'artist_name' => 'required|string',
            'album_name' => 'required|string',
            'release_date' => 'nullable|date',
            'itunes_id' => 'nullable|string',
        ]);

        // Encontra ou cria a banda
        $band = Band::firstOrCreate(
            ['name' => $request->input('artist_name')],
            ['photo' => null]
        );


        // Busca detalhes do álbum na API para obter a imagem
        $albumResponse = Http::get('https://itunes.apple.com/lookup', [
            'id' => $request->input('itunes_id'),
            'entity' => 'album'
        ]);

        $albumData = $albumResponse->json()['results'][0] ?? null;
        $imageUrl = null;

        if ($albumData && isset($albumData['artworkUrl100'])) {

            $imageUrl = $this->downloadAndSaveImage($albumData['artworkUrl100'], $request->input('album_name'));

        }

        $album = Album::create([
            'band_id' => $band->id,
            'title' => $request->input('album_name'),
            'artist' => $band->name,
            'release_date' => $request->input('release_date') ? Carbon::parse($request->input('release_date')) : null,
            'itunes_id' => $request->input('itunes_id'),
            'image' => $imageUrl,
        ]);


        $response = Http::get('https://itunes.apple.com/lookup', [
            'id' => $request->input('itunes_id'),
            'entity' => 'song'
        ]);

        $results = $response->json()['results'] ?? [];
        array_shift($results);

        
        foreach ($results as $songData) {
            if (isset($songData['trackName'])) {
                Song::create([
                    'album_id' => $album->id,
                    'track_name' => $songData['trackName'],
                    'artist_name' => $songData['artistName'] ?? $request->input('artist_name'),
                    'track_time' => $songData['trackTimeMillis'] ?? null,
                    'preview_url' => $songData['previewUrl'] ?? null,
                    'itunes_id' => $songData['trackId'] ?? null,
                    'itunes_url' => $songData['trackViewUrl'] ?? null,
                ]);
            }
        }

        return back()->with('success', 'Álbum "' . $request->input('album_name') . '" e suas músicas importados com sucesso!');
    }

    /**
     * Baixa e salva uma imagem da URL no storage
     */
    private function downloadAndSaveImage($imageUrl, $albumName)
    {
        try {
            $imageUrl = str_replace('100x100', '300x300', $imageUrl); // Pega uma imagem maior - A API retorna 100x100 por padrão mas existem tamanhos maiores;

            // Baixa a imagem
            $imageContent = Http::get($imageUrl)->body();

            // Gera um nome único para o arquivo
            $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $fileName = 'albums/' . Str::slug($albumName) . '_' . time() . '.' . $extension;

            // Salva no storage
            Storage::disk('public')->put($fileName, $imageContent);

            return $fileName;
        } catch (\Exception $e) {
            // Se der erro no download, retorna null
            return null;
        }
    }
}
