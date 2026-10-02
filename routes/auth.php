<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordRecoveryController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

// Signup
Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/signup', [AuthController::class, 'signup'])
    ->name('signup.store');


// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.authenticate');


// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Password Recovery
|--------------------------------------------------------------------------
*/

// Forgot Password
Route::get('/password/forgot', [PasswordRecoveryController::class, 'showForgotForm'])
    ->name('password.request');

Route::post('/password/forgot', [PasswordRecoveryController::class, 'sendResetLink'])
    ->name('password.email');


// Reset Password
Route::get('/password/reset/{token}', [PasswordRecoveryController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/password/reset', [PasswordRecoveryController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.update');