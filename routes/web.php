<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ItunesController;
use App\Http\Controllers\BandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlaylistController;

// Home pública
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ========== AUTENTICAÇÃO ==========
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ========== DASHBOARD (Autenticado) ==========
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/dashboard/album/{id}', [DashboardController::class, 'showAlbum'])->name('dashboard.album')->middleware('auth');
Route::delete('/dashboard/album/{id}', [DashboardController::class, 'destroyAlbum'])->name('dashboard.album.destroy')->middleware('auth');
Route::get('/dashboard/album/{id}/manage-songs', [DashboardController::class, 'manageSongs'])->name('dashboard.album.manage-songs')->middleware('auth');
Route::delete('/dashboard/album/{albumId}/song/{songId}', [DashboardController::class, 'destroySong'])->name('dashboard.album.song.destroy')->middleware('auth');

// ========== BANDAS  ==========
Route::resource('bands', BandController::class);
// Proteger rotas específicas de banda para admin
Route::middleware('auth')->group(function () {
    Route::get('bands/create', [BandController::class, 'create'])->middleware('admin')->name('bands.create');
    Route::post('bands', [BandController::class, 'store'])->middleware('admin')->name('bands.store');
    Route::get('bands/{band}/edit', [BandController::class, 'edit'])->middleware('admin')->name('bands.edit');
    Route::put('bands/{band}', [BandController::class, 'update'])->middleware('admin')->name('bands.update');
    Route::delete('bands/{band}', [BandController::class, 'destroy'])->middleware('admin')->name('bands.destroy');
});

// ========== ÁLBUNS ==========
Route::resource('albums', AlbumController::class);
// Proteger rotas específicas de álbum para admin
Route::middleware('auth')->group(function () {
    Route::get('albums/create', [AlbumController::class, 'create'])->middleware('admin')->name('albums.create');
    Route::post('albums', [AlbumController::class, 'store'])->middleware('admin')->name('albums.store');
    Route::get('albums/{album}/edit', [AlbumController::class, 'edit'])->middleware('admin')->name('albums.edit');
    Route::put('albums/{album}', [AlbumController::class, 'update'])->middleware('admin')->name('albums.update');
    Route::delete('albums/{album}', [AlbumController::class, 'destroy'])->middleware('admin')->name('albums.destroy');
});

// ========== PLAYLISTS ==========
Route::middleware('auth')->group(function () {
    Route::resource('playlists', PlaylistController::class);
    Route::post('playlists/{playlist}/add-music', [PlaylistController::class, 'addMusic'])->name('playlists.add-music');
    Route::post('playlists/{playlist}/remove-music', [PlaylistController::class, 'removeMusic'])->name('playlists.remove-music');
});

// ========== MÚSICAS ==========
Route::get('/music', [SongController::class, 'index'])->name('music.index');

// ========== iTunes API ==========
Route::get('/itunes/search', [ItunesController::class, 'searchPage'])->name('itunes.search');
Route::get('/itunes/api/search', [ItunesController::class, 'search'])->name('itunes.api.search'); // Para AJAX
Route::get('/itunes/results', [ItunesController::class, 'results'])->name('itunes.results');
Route::get('/itunes/album/{collectionId}', [ItunesController::class, 'show'])->name('itunes.album');
Route::post('/itunes/import-artist', [ItunesController::class, 'importArtist'])->middleware('auth', 'admin')->name('itunes.import-artist');
Route::post('/itunes/import-album', [ItunesController::class, 'importAlbum'])->middleware('auth', 'admin')->name('itunes.import-album');


