<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('posts')->name('posts.')->group(function () {

        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::post('/storeComment', [PostController::class, 'storeComment'])->name('storeComment');
        Route::get('/create',[PostController::class,'create'])->name('create');
        Route::post('/store',[PostController::class,'store'])->name('store');
        Route::post('/show',[PostController::class,'show'])->name('show');
    });
});

require __DIR__ . '/auth.php';
