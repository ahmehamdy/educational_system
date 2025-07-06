<?php

use App\Http\Controllers\InstructorController;
use App\Http\Controllers\MaterialController;
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
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::post('/show', [PostController::class, 'show'])->name('show');
    });
    Route::prefix('instructors')->name('instructors.')->group(function () {
        Route::get('/', [InstructorController::class, 'index'])->name('index');
        Route::get('/show/{id}', [InstructorController::class, 'show'])->name('show');
    });
    Route::prefix('materials')->name('materials.')->group(function () {
        Route::get('/', [MaterialController::class, 'index'])->name('index');
        Route::get('/create', [MaterialController::class, 'create'])->name('create');
        Route::post('/store', [MaterialController::class, 'store'])->name('store');
        Route::get('/show/{id}', [MaterialController::class, 'show'])->name('show');
    });
});

// require __DIR__ . '/auth.php';


Route::get('/reset-password/{token}', function ($token) {
    return response()->json(['token' => $token]);
})->name('password.reset');
