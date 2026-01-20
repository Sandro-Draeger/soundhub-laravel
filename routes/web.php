<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\AlbumController;

//rota para homepage
Route::get('/music', [MusicController::class, 'index']);

//rota para o Login

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Route::middleware('auth')->group(function () {
    Route::get('/music', [MusicController::class, 'index'])->name('music.index');
//});

//rotas para adicionar, editar e deletar
Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');
Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');

Route::get('/albums/{album}/edit', [AlbumController::class, 'edit'])->name('albums.edit');
Route::put('/albums/{album}', [AlbumController::class, 'update'])->name('albums.update');


Route::get('/', function () {
    return view('welcome');
});
