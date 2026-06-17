<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ActivityController;

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return redirect()->route('agendas.index');
    });

    Route::get('/home', function () {
        return view('home');
    });

    Route::resource('agendas', AgendaController::class);
    Route::resource('activities', ActivityController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::resource('activities', ActivityController::class);

Route::resource('agendas', AgendaController::class);
