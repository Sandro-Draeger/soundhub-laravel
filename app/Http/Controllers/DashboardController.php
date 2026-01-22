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
        $albums = Album::with('band')->get();

        return view('dashboard', compact('bands', 'albums'));
    }
}

