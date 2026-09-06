<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\AuthController;

Route::get('/signup', function () {return view('auth.signup');})->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.store');

Route::post('/students', [StudentController::class, 'store']);
Route::get('/login', function () { return view('auth.login'); })->name('login');


