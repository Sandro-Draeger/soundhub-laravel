<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusicController;


Route::get('/music', [MusicController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});
