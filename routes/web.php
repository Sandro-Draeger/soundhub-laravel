<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ItunesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\BandController;
use App\Http\Controllers\SongController;


/*
|--------------------------------------------------------------------------
| HOME (PÚBLICO)
|--------------------------------------------------------------------------
*/
Route::get('/', [AlbumController::class, 'index'])->name('home');


/*
|--------------------------------------------------------------------------
| AUTENTICAÇÃO
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


/*
|--------------------------------------------------------------------------
| DASHBOARD (ADMIN)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'admin']);
Route::get('/dashboard/album/{id}', [DashboardController::class, 'showAlbum'])->name('dashboard.album')->middleware(['auth', 'admin']);
Route::delete('/dashboard/album/{id}', [DashboardController::class, 'destroyAlbum'])->name('dashboard.album.destroy')->middleware(['auth', 'admin']);
Route::get('/dashboard/album/{id}/manage-songs', [DashboardController::class, 'manageSongs'])->name('dashboard.album.manage-songs')->middleware(['auth', 'admin']);
Route::delete('/dashboard/album/{albumId}/song/{songId}', [DashboardController::class, 'destroySong'])->name('dashboard.album.song.destroy')->middleware(['auth', 'admin']);


/*
|--------------------------------------------------------------------------
| ALBUMS
|--------------------------------------------------------------------------
*/
// Público
Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
Route::get('/albums/{album}', [AlbumController::class, 'show'])->name('albums.show');

// Admin
Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create')->middleware(['auth', 'admin']);
Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store')->middleware(['auth', 'admin']);
Route::get('/albums/{album}/edit', [AlbumController::class, 'edit'])->name('albums.edit')->middleware(['auth', 'admin']);
Route::put('/albums/{album}', [AlbumController::class, 'update'])->name('albums.update')->middleware(['auth', 'admin']);
Route::delete('/albums/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy')->middleware(['auth', 'admin']);


/*
|--------------------------------------------------------------------------
| PLAYLISTS (USER AUTENTICADO)
|--------------------------------------------------------------------------
*/
Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index')->middleware('auth');
Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create')->middleware('auth');
Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store')->middleware('auth');
Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])->name('playlists.show')->middleware('auth');
Route::get('/playlists/{playlist}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit')->middleware('auth');
Route::put('/playlists/{playlist}', [PlaylistController::class, 'update'])->name('playlists.update')->middleware('auth');
Route::delete('/playlists/{playlist}', [PlaylistController::class, 'destroy'])->name('playlists.destroy')->middleware('auth');


/*
|--------------------------------------------------------------------------
| ROTAS ADICIONAIS PARA PLAYLISTS
|--------------------------------------------------------------------------
*/
Route::post('/playlist/add-song', [PlaylistController::class, 'addSong'])->name('playlist.add-song')->middleware('auth');
Route::post('/playlist/remove-song', [PlaylistController::class, 'removeSong'])->name('playlist.remove-song')->middleware('auth');


/*
|--------------------------------------------------------------------------
| ITUNES API
|--------------------------------------------------------------------------
*/
Route::get('/itunes/search', [ItunesController::class, 'searchPage'])->name('itunes.search');
Route::get('/itunes/api/search', [ItunesController::class, 'search'])->name('itunes.api.search');
Route::get('/itunes/results', [ItunesController::class, 'results'])->name('itunes.results');
Route::get('/itunes/album/{collectionId}', [ItunesController::class, 'show'])->name('itunes.album');
Route::post('/itunes/import-artist', [ItunesController::class, 'importArtist'])->name('itunes.import-artist')->middleware(['auth', 'admin']);
Route::post('/itunes/import-album', [ItunesController::class, 'importAlbum'])->name('itunes.import-album')->middleware(['auth', 'admin']);



/*
|--------------------------------------------------------------------------
| BANDAS
|--------------------------------------------------------------------------
*/
Route::get('/bands', [BandController::class, 'index'])->name('bands.index');
Route::get('/bands/{band}', [BandController::class, 'show'])->name('bands.show');


/*
|--------------------------------------------------------------------------
| MÚSICAS
|--------------------------------------------------------------------------
*/
Route::get('/music', [SongController::class, 'index'])
    ->name('music.index');

