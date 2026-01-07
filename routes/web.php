<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');

    Route::get('/users', [UsersController::class, 'index'])->name('users');

    Route::get('/user/{user}', [UsersController::class, 'userById'])->name('details');

    Route::get('/user/{user}/edit', [UsersController::class, 'edit'])->name('edit');
    Route::patch('/user/{user}', [UsersController::class, 'update'])->name('update');

    Route::get('/create', [UsersController::class, 'createUser'])->name('create');
    Route::post('/save', [UsersController::class, 'save'])->name('save');

    Route::delete('/delete/{user}', [UsersController::class, 'delete'])->name('delete');
});
