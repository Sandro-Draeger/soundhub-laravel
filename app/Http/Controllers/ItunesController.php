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
    // Página inicial da busca
    public function searchPage()
    {
        return view('itunes.search');
    }

    // Busca artistas e álbuns (AJAX)
    public function search(Request $request)
    {
        $term = $request->input('term');

        // Evita busca vazia
        if (empty($term)) {
            return response()->json(['results' => []]);
        }

        $response = Http::get('https://itunes.apple.com/search', [
            'term' => $term,
            'entity' => 'artist,album',
            'limit' => 20
        ]);

        $data = $response->json();

        return response()->json($data['results'] ?? []);
    }

    // Mostra resultados da busca
    public function results(Request $request)
    {
        $term = $request->input('term');
        $type = $request->input('type', 'artist');

        if (empty($term)) {
            return redirect()
                ->route('itunes.search')
                ->with('error', 'Digite algo para pesquisar');
        }

        $response = Http::get('https://itunes.apple.com/search', [
            'term' => $term,
            'entity' => $type,
            'limit' => 50
        ]);

        $results = $response->json()['results'] ?? [];

        return view('itunes.results', compact('results', 'term', 'type'));
    }

    // Detalhes do álbum e músicas
    public function show($collectionId)
    {
        $response = Http::get('https://itunes.apple.com/lookup', [
            'id' => $collectionId,
            'entity' => 'song'
        ]);

        $results = $response->json()['results'] ?? [];

        if (count($results) === 0) {
            return redirect()
                ->route('itunes.search')
                ->with('error', 'Álbum não encontrado');
        }

        $album = null;
        $songs = [];

        foreach ($results as $index => $item) {

            // Primeiro item é o álbum
            if ($index === 0) {
                $album = $item;
                continue;
            }

            // Restante são músicas
            $songs[] = $item;
        }

        return view('itunes.album-detail', compact('album', 'songs', 'collectionId'));
    }

    // Importa artista/banda
    public function importArtist(Request $request)
    {
        // Apenas admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $artistName = $request->artist_name;
        $artistPhoto = $request->artist_photo;

        // Verifica se já existe
        $band = Band::where('name', $artistName)->first();

        if ($band) {
            return back()->with('error', 'Esta banda já existe.');
        }

        Band::create([
            'name' => $artistName,
            'photo' => $artistPhoto
        ]);

        return back()->with('success', 'Banda importada com sucesso!');
    }

    // Importa álbum e músicas
    public function importAlbum(Request $request)
    {
        // Apenas admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'artist_name' => 'required',
            'album_name' => 'required',
            'release_date' => 'nullable|date',
            'itunes_id' => 'nullable',
        ]);

        // Busca ou cria a banda
        $band = Band::firstOrCreate(
            ['name' => $request->artist_name],
            ['photo' => null]
        );

        // Busca dados do álbum no iTunes
        $albumResponse = Http::get('https://itunes.apple.com/lookup', [
            'id' => $request->itunes_id
        ]);

        $albumData = $albumResponse->json()['results'][0] ?? null;
        $imagePath = null;

        if ($albumData && isset($albumData['artworkUrl100'])) {
            $imagePath = $this->downloadAndSaveImage(
                $albumData['artworkUrl100'],
                $request->album_name
            );
        }

        // Cria o álbum
        $album = Album::create([
            'band_id' => $band->id,
            'title' => $request->album_name,
            'artist' => $band->name,
            'release_date' => $request->release_date
                ? Carbon::parse($request->release_date)
                : null,
            'itunes_id' => $request->itunes_id,
            'image' => $imagePath,
        ]);

        // Busca músicas do álbum
        $songsResponse = Http::get('https://itunes.apple.com/lookup', [
            'id' => $request->itunes_id,
            'entity' => 'song'
        ]);

        $songsData = $songsResponse->json()['results'] ?? [];
        $songs = [];

        foreach ($songsData as $index => $song) {

            // Primeiro item é o álbum
            if ($index === 0) {
                continue;
            }

            if (!isset($song['trackName'])) {
                continue;
            }

            Song::create([
                'album_id' => $album->id,
                'track_name' => $song['trackName'],
                'artist_name' => $song['artistName'] ?? $band->name,
                'track_time' => $song['trackTimeMillis'] ?? null,
                'preview_url' => $song['previewUrl'] ?? null,
                'itunes_id' => $song['trackId'] ?? null,
                'itunes_url' => $song['trackViewUrl'] ?? null,
            ]);
        }

        return back()->with('success', 'Álbum e músicas importados!');
    }

    // Baixa imagem do álbum e salva no storage
    private function downloadAndSaveImage($imageUrl, $albumName)
    {
        // Troca para imagem maior
        $imageUrl = str_replace('100x100', '300x300', $imageUrl);

        $imageContent = Http::get($imageUrl)->body();

        $extension = pathinfo($imageUrl, PATHINFO_EXTENSION) ?: 'jpg';

        $fileName =
            'albums/' .
            Str::slug($albumName) .
            '_' .
            time() .
            '.' .
            $extension;

        Storage::disk('public')->put($fileName, $imageContent);

        return $fileName;
    }
}
