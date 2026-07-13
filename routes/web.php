<?php


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/stijn', function () {
    return view('pages.stijn');
})->name('stijn');
