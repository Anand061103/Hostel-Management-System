<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SecurityDepositController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WardenController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PasswordRecoveryController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Hostel;


Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.store');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/owner/hostels/{hostel}/enter', [OwnerController::class, 'enterHostel'])->middleware('auth')->name('owner.hostels.enter');


//owner profile
Route::get('/owner/profile', [OwnerController::class, 'profile'])->middleware('auth')->name('owner.profile');
Route::get('/owner/profile/edit', [OwnerController::class, 'editProfile'])->middleware('auth')->name('profile.edit');
Route::put('/owner/profile', [OwnerController::class, 'updateProfile'])->middleware('auth')->name('profile.update');
Route::get('/profile/change-email', [OwnerController::class, 'editEmail'])->middleware('auth')->name('profile.email.edit');
Route::put('/profile/change-email', [OwnerController::class, 'updateEmail'])->middleware('auth')->name('profile.email.update');
Route::get('/profile/change-password', [OwnerController::class, 'editPassword'])->middleware('auth')->name('profile.password.edit');
Route::put('/profile/change-password', [OwnerController::class, 'updatePassword'])->middleware('auth')->name('profile.password.update');
//warden profile 
Route::get('/profile', [OwnerController::class, 'profile'])->middleware('auth')->name('profile');
Route::get('/profile/edit', [OwnerController::class, 'editWardenProfile'])->middleware('auth')->name('warden.profile.edit');
Route::put('/profile', [OwnerController::class, 'updateWardenProfile'])->middleware('auth')->name('warden.profile.update');



// Password Recovery

// Forgot Password Page — login ki zarurat nahi
Route::get('/password/forgot', [PasswordRecoveryController::class, 'showForgotForm'])->name('password.request');

// Send Reset Link — login ki zarurat nahi
Route::post('/password/forgot', [PasswordRecoveryController::class, 'sendResetLink'])->name('password.email');

// Reset Password Page — sirf logged-out user
Route::get('/password/reset/{token}', [PasswordRecoveryController::class, 'showResetForm'])->middleware('guest')->name('password.reset');

// Update Password — sirf logged-out user
Route::post('/password/reset', [PasswordRecoveryController::class, 'resetPassword'])->middleware('guest')->name('password.update');



Route::get('/owner/exit-hostel', [OwnerController::class, 'exitHostel'])->middleware('auth')->name('owner.exitHostel');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/owner/switch-hostel', [OwnerController::class, 'switchHostel'])->middleware('auth')->name('owner.switchHostel');



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

Route::resource('hostels', HostelController::class);


Route::resource('wardens', WardenController::class);


Route::get('/hostel/dashboard', function () {
    $user = Auth::user();

    $hostelId = session('current_hostel_id');

    if (! $hostelId) {
        return redirect()->route('owner.profile');
    }

    $hostel = Hostel::findOrFail($hostelId);

    return view('dashboard.hostel', compact(
        'user',
        'hostel'
    ));
})
    ->middleware('auth')
    ->name('hostel.dashboard');


Route::get('/students/{student}/checkout', [CheckoutController::class, 'create'])->name('students.checkout.create');
Route::post('/students/{student}/checkout', [CheckoutController::class, 'store'])->name('students.checkout.store');
Route::post('/students/{student}/checkout/pay-fees', [CheckoutController::class, 'payFees'])->name('students.checkout.payFees');

//student fees payment route
Route::post('/students/{student}/payment/order', [PaymentController::class, 'createOrder'])->name('students.payment.order');
