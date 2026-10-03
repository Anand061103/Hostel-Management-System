<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Apartment\Controllers\ApartmentPlanController;
use App\Modules\Apartment\Controllers\OwnerOnboardingController;

Route::get('/apartment/plans', [ApartmentPlanController::class, 'index'])
    ->name('apartment.plans');

Route::post('/apartment/plans/select', [ApartmentPlanController::class, 'select'])
    ->name('apartment.plans.select');

Route::post('/apartment/plans/payment/verify', [ApartmentPlanController::class, 'verifyPayment'])
    ->name('apartment.plans.payment.verify');


// Apartment Onboarding
Route::get('/apartment/onboarding', [OwnerOnboardingController::class, 'index'])
    ->name('apartment.onboarding');

Route::post('/apartment/onboarding', [OwnerOnboardingController::class, 'store'])
    ->name('apartment.onboarding.store');