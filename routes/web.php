<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

// Show registration form
Route::get('/register', [RegisterController::class, 'showForm'])->name('register.form');

// Handle form submission
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// AJAX: Check if username already exists
Route::post('/check-username', [RegisterController::class, 'checkUsername'])->name('check.username');
