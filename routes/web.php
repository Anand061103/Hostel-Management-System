<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SecurityDepositController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.store');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth')->name('dashboard');

Route::delete('/students/bulk-delete', [StudentController::class, 'bulkDestroy'])->name('students.bulkDestroy');
Route::resource('students', StudentController::class)->middleware('auth');
Route::resource('rooms', RoomController::class);

Route::post('/beds/{bed}/assign', [RoomController::class, 'assignStudent'])->name('beds.assign');
Route::post('/beds/{bed}/checkout', [RoomController::class, 'checkoutStudent'])->name('beds.checkout');

Route::resource('fees', FeeController::class);
Route::post('/fees/{fee}/payment', [FeeController::class, 'recordPayment'])->name('fees.recordPayment');

Route::resource('security-deposits', SecurityDepositController::class);
Route::post('/security-deposits/{securityDeposit}/payment', [SecurityDepositController::class, 'recordPayment'])->name('security-deposits.recordPayment');

Route::resource('beds', BedController::class);
Route::get('beds/{bed}/assign', [BedController::class, 'assign'])->name('beds.assign');
Route::post('beds/{bed}/assign', [BedController::class, 'storeAssignment'])->name('beds.storeAssignment');
