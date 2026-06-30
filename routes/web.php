<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\FriendController;
use App\Http\Controllers\AgendaInvitationController;

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

    Route::post('/agenda/{agenda}/invite', [AgendaInvitationController::class, 'sendInvitation'])->name('agenda.invite');
    Route::post('/agenda/invitations/{invitation}/accept', [AgendaInvitationController::class, 'accept'])->name('agenda.invitations.accept');
    Route::post('/agenda/invitations/{invitation}/decline', [AgendaInvitationController::class, 'decline'])->name('agenda.invitations.decline');


    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::get('/friends/search-users', [FriendController::class, 'searchUsers']);
    Route::get('/friends/search', [FriendController::class, 'searchFriends']);
    Route::post('/friends/request/{user}', [FriendController::class, 'sendRequest'])->name('friends.request');
    Route::post('/friends/request/{request}/accept', [FriendController::class, 'accept']);
    Route::post('/friends/request/{request}/decline', [FriendController::class, 'decline']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

