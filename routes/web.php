<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Website
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Route Files
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
require __DIR__.'/owner.php';
require __DIR__.'/hostel.php';
require __DIR__.'/apartment.php';