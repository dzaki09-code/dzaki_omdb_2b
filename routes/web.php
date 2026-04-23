<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


// Routing untuk Auth
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register_process'])->name('signup');


Route::get('/dashboard', function () {
    return view('panel control.dashboard');
});
Route::get('/favorit', function () {
    return view('panel control.favorit');
});