<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;

Route::get('/signup', function () {return view('auth.signup');})->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.store');

Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/dashboard', function () {
return view('dashboard.index');})->middleware('auth')->name('dashboard');

Route::delete('/students/bulk-delete', [StudentController::class, 'bulkDestroy'])->name('students.bulkDestroy');
Route::resource('students', StudentController::class)->middleware('auth');
Route::resource('rooms', RoomController::class);

Route::post('/beds/{bed}/assign', [RoomController::class, 'assignStudent'])->name('beds.assign');
Route::post('/beds/{bed}/checkout', [RoomController::class, 'checkoutStudent'])->name('beds.checkout');