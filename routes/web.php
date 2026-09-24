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
use App\Models\Hostel;
use Illuminate\Support\Facades\Auth;
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

Route::get('/owner/profile', [OwnerController::class, 'profile'])->middleware('auth')->name('owner.profile');
Route::get('/owner/hostels/{hostel}/enter', [OwnerController::class, 'enterHostel'])->middleware('auth')->name('owner.hostels.enter');
Route::get('/profile', [OwnerController::class, 'profile'])->middleware('auth')->name('profile');
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

Route::get('/wardens/create', [WardenController::class, 'create'])->name('wardens.create');
Route::post('/wardens', [WardenController::class, 'store'])->name('wardens.store');

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