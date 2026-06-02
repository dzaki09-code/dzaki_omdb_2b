<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanelControl\DashboardController;
use Illuminate\support\Facades\App;
use App\Http\Controllers\PanelControl\MovieController;
use App\Http\Controllers\PanelControl\FavoriteController;

//swith language
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
        App::setLocale($locale);
    }
    return redirect()->back();
});


// Routing untuk Auth
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register_process'])->name('signup');
Route::post('/login', [AuthController::class, 'login'])->name('signin');
Route::get('/logout', [AuthController::class, 'logout'])->name('signout');

Route::get('dashboard', function () {
    return view('panel control.dashboard');
});
Route::get('favorit', [FavoriteController::class, 'index'])->middleware('check.login')->name('favorit');

Route::prefix('panel control')->middleware('check.login')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');   

    Route::get('movies', [MovieController::class, 'index'])->name('movies.search');
    Route::get('movies/{imdbId}', [MovieController::class, 'detail'])->name('movies.detail');
    
    Route::get('favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('favorites/{imdbId}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});


