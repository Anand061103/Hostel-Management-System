<?php

use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Owner Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Hostel Selection
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/owner/hostels/{hostel}/enter',
        [OwnerController::class, 'enterHostel']
    )->name('owner.hostels.enter');

    Route::get(
        '/owner/switch-hostel',
        [OwnerController::class, 'switchHostel']
    )->name('owner.switchHostel');

    Route::get(
        '/owner/exit-hostel',
        [OwnerController::class, 'exitHostel']
    )->name('owner.exitHostel');


    /*
    |--------------------------------------------------------------------------
    | Owner Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/owner/profile',
        [OwnerController::class, 'profile']
    )->name('owner.profile');

    Route::get(
        '/owner/profile/edit',
        [OwnerController::class, 'editProfile']
    )->name('profile.edit');

    Route::put(
        '/owner/profile',
        [OwnerController::class, 'updateProfile']
    )->name('profile.update');


    /*
    |--------------------------------------------------------------------------
    | Owner Email / Password
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile/change-email',
        [OwnerController::class, 'editEmail']
    )->name('profile.email.edit');

    Route::put(
        '/profile/change-email',
        [OwnerController::class, 'updateEmail']
    )->name('profile.email.update');

    Route::get(
        '/profile/change-password',
        [OwnerController::class, 'editPassword']
    )->name('profile.password.edit');

    Route::put(
        '/profile/change-password',
        [OwnerController::class, 'updatePassword']
    )->name('profile.password.update');


    /*
    |--------------------------------------------------------------------------
    | Warden Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [OwnerController::class, 'profile']
    )->name('profile');

    Route::get(
        '/profile/edit',
        [OwnerController::class, 'editWardenProfile']
    )->name('warden.profile.edit');

    Route::put(
        '/profile',
        [OwnerController::class, 'updateWardenProfile']
    )->name('warden.profile.update');

});