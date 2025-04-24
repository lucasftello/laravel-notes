<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Middleware\CheckIfUserIsLogged;
use App\Http\Middleware\CheckIfUserIsNotLogged;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::middleware([CheckIfUserIsLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'handleRegister'])->name('register.submit');
});

// Protected Routes
Route::middleware([CheckIfUserIsNotLogged::class])->group(function () {
    Route::get('/', function () {
        return redirect()->route('notes');
    });
    Route::get('/notes', [NoteController::class, 'index'])->name('notes');

    Route::get('/notes/create', [NoteController::class, 'createNote'])->name('note.create');
    Route::post('/notes/create', [NoteController::class, 'handleCreateNote'])->name('note.create.submit');

    Route::get('/notes/edit/{id}', [NoteController::class, 'editNote'])->name('note.edit');
    Route::put('/notes/edit/{id}', [NoteController::class, 'handleEditNote'])->name('note.edit.submit');

    Route::get('/notes/delete/{id}', [NoteController::class, 'deleteNote'])->name('note.delete');
    Route::delete('/notes/delete/{id}', [NoteController::class, 'handleDeleteNote'])->name('note.delete.submit');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
