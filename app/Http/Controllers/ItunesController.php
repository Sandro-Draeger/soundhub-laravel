<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ItunesController extends Controller
{
    public function search(Request $request)
    {
        $term = $request->term;

        $response = Http::get('https://itunes.apple.com/search', [
            'term' => $term,
            'entity' => 'album',
            'limit' => 10
        ]);

        return response()->json(
            $response->json()['results']
        );
    }
}
