<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class MusicController extends Controller

{

public function index(Request $request)
{
    $albums = [];

    if ($request->filled('term')) {
        $response = Http::get('https://itunes.apple.com/search', [
            'term' => $request->term,
            'entity' => 'album',
            'limit' => 10
        ]);

        $albums = $response->json()['results'] ?? [];
    }

    return view('song.index', compact('albums'));
}


}
