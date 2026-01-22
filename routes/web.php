<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ItunesController;
use App\Http\Controllers\BandController;

// Home
Route::get('/', function () {
    return view('welcome');
});

// Página principal de músicas
Route::get('/music', [MusicController::class, 'index'])
    ->name('music.index');

//rota bandController
Route::resource('/bands', BandController::class);



// API do iTunes (JSON)
Route::get('/itunes/search', [ItunesController::class, 'search']);

//Quando clicar no álbum busca músicas
Route::get('/admin/albums/{collectionId}', [AlbumController::class, 'showFromItunes']);
// Albums
Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');
Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
Route::get('/albums/{album}/edit', [AlbumController::class, 'edit'])->name('albums.edit');
Route::put('/albums/{album}', [AlbumController::class, 'update'])->name('albums.update');
