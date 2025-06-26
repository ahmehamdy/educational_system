<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostController;

    Route::prefix('posts')->name('posts.')->group(function () {

        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::post('/storeComment', [PostController::class, 'storeComment'])->name('storeComment');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::post('/show', [PostController::class, 'show'])->name('show');
    });
