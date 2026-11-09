<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPageController::class)->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Modules\Catalog\Http\Controllers\CatalogController;
use App\Modules\Circulation\Http\Controllers\CirculationController;

// Endpoint API Studi Kasus Perpustakaan
Route::prefix('api')->group(function () {
    Route::get('/catalog/books', [CatalogController::class, 'index']);
    Route::post('/circulation/borrow', [CirculationController::class, 'borrow'])
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
});
