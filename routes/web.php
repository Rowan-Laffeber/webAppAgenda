<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\FriendController;

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

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');

    Route::post('/logout', [AuthController::class, 'logout']);
});

