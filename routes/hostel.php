<?php

use App\Modules\Hostel\Controllers\DashboardController;
use App\Modules\Hostel\Controllers\BedController;
use App\Modules\Hostel\Controllers\CheckoutController;
use App\Modules\Hostel\Controllers\FeeController;
use App\Modules\Hostel\Controllers\HostelController;
use App\Modules\Hostel\Controllers\PaymentController;
use App\Modules\Hostel\Controllers\RoomController;
use App\Modules\Hostel\Controllers\SecurityDepositController;
use App\Modules\Hostel\Controllers\StudentController;
use App\Modules\Hostel\Controllers\WardenController;
use App\Modules\Hostel\Models\Hostel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Hostel Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    Route::get('/hostel/dashboard', function () {

        $user = Auth::user();

        $hostelId = session('current_hostel_id');

        if (! $hostelId) {
            return redirect()->route('owner.profile');
        }

        $hostel = Hostel::findOrFail($hostelId);

        return view(
            'hostel.dashboard.index',
            compact('user', 'hostel')
        );

    })->name('hostel.dashboard');


    /*
    |--------------------------------------------------------------------------
    | Hostels
    |--------------------------------------------------------------------------
    */

    Route::resource('hostels', HostelController::class);


    /*
    |--------------------------------------------------------------------------
    | Students
    |--------------------------------------------------------------------------
    */

    Route::delete(
        '/students/bulk-delete',
        [StudentController::class, 'bulkDestroy']
    )->name('students.bulkDestroy');

    Route::resource(
        'students',
        StudentController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Rooms
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'rooms',
        RoomController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Beds
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'beds',
        BedController::class
    );

    Route::get(
        '/beds/{bed}/assign',
        [BedController::class, 'assign']
    )->name('beds.assign');

    Route::post(
        '/beds/{bed}/assign',
        [BedController::class, 'storeAssignment']
    )->name('beds.storeAssignment');


    /*
    |--------------------------------------------------------------------------
    | Room → Bed Actions
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/beds/{bed}/checkout',
        [RoomController::class, 'checkoutStudent']
    )->name('beds.checkout');


    /*
    |--------------------------------------------------------------------------
    | Fees
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'fees',
        FeeController::class
    );

    Route::post(
        '/fees/{fee}/payment',
        [FeeController::class, 'recordPayment']
    )->name('fees.recordPayment');


    /*
    |--------------------------------------------------------------------------
    | Security Deposits
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'security-deposits',
        SecurityDepositController::class
    );

    Route::post(
        '/security-deposits/{securityDeposit}/payment',
        [SecurityDepositController::class, 'recordPayment']
    )->name('security-deposits.recordPayment');


    /*
    |--------------------------------------------------------------------------
    | Checkout
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/students/{student}/checkout',
        [CheckoutController::class, 'create']
    )->name('students.checkout.create');

    Route::post(
        '/students/{student}/checkout',
        [CheckoutController::class, 'store']
    )->name('students.checkout.store');

    Route::post(
        '/students/{student}/checkout/pay-fees',
        [CheckoutController::class, 'payFees']
    )->name('students.checkout.payFees');


    /*
    |--------------------------------------------------------------------------
    | Student Online Payment
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/students/{student}/payment/order',
        [PaymentController::class, 'createOrder']
    )->name('students.payment.order');

    Route::post(
        '/students/{student}/payment/verify',
        [PaymentController::class, 'verifyPayment']
    )->name('students.payment.verify');


    /*
    |--------------------------------------------------------------------------
    | Wardens
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'wardens',
        WardenController::class
    );

});