<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Models\Album;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $bands = Band::all();
        // Carrega apenas álbuns que têm band_id válido
        $albums = Album::whereNotNull('band_id')->with('band')->get();

        return view('dashboard', compact('bands', 'albums'));
    }
}

