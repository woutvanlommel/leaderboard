<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::view('/', 'pages.home')->name('home');

    Route::view('profile', 'profile')->name('profile');
});

require __DIR__.'/auth.php';
