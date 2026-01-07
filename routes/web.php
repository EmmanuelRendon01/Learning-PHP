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

    Route::get('/user/{id}', [UsersController::class, 'userById'])->name('details');


    Route::get('/user/{id}/edit', [UsersController::class, 'edit'])->name('edit');
    Route::patch('/user/{id}', [UsersController::class, 'update'])->name('update');

    Route::get('/create', [UsersController::class, 'createUser'])->name('create');
    Route::post('/save', [UsersController::class, 'save'])->name('save');

    Route::delete('/delete/{id}', [UsersController::class, 'delete'])->name('delete');
});
