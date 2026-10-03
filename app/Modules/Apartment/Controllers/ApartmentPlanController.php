<?php

namespace App\Modules\Apartment\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class ApartmentPlanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Plans Page
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        if (! $request->session()->has('signup_data')) {
            return redirect()->route('signup');
        }

        $plans = config('apartment.plans');

        return view('apartment.plans.index', compact('plans'));
    }


    /*
    |--------------------------------------------------------------------------
    | Select Plan
    |--------------------------------------------------------------------------
    */

    public function select(Request $request)
    {
        if (! $request->session()->has('signup_data')) {
            return redirect()->route('signup');
        }

        $data = $request->validate([
            'plan' => [
                'required',
                'in:trial,399,999',
            ],
        ]);

        $plans = config('apartment.plans');

        $plan = $plans[$data['plan']];


        /*
        |--------------------------------------------------------------------------
        | Free Trial
        |--------------------------------------------------------------------------
        */

        if ($data['plan'] === 'trial') {

            $subscription = Subscription::create([
                'management_type' => 'apartment',
                'plan' => 'trial',
                'amount' => 0,
                'duration_days' => 7,
                'status' => 'active',
                'starts_at' => now(),
                'expires_at' => now()->addDays(7),
            ]);

            $request->session()->put([
                'selected_apartment_plan' => 'trial',
                'selected_subscription_id' => $subscription->id,
            ]);

            return redirect()->route('apartment.onboarding');
        }


        /*
        |--------------------------------------------------------------------------
        | Paid Plans
        |--------------------------------------------------------------------------
        */

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $order = $api->order->create([
            'amount' => $plan['amount'] * 100,
            'currency' => 'INR',
            'receipt' => 'apartment_' . uniqid(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Create Pending Subscription
        |--------------------------------------------------------------------------
        */

        $subscription = Subscription::create([
            'management_type' => 'apartment',
            'plan' => $data['plan'],
            'amount' => $plan['amount'],
            'duration_days' => $plan['duration_days'],
            'status' => 'pending',
            'razorpay_order_id' => $order['id'],
        ]);


        $request->session()->put([
            'selected_apartment_plan' => $data['plan'],
            'selected_subscription_id' => $subscription->id,
        ]);


        return view('apartment.plans.checkout', [
            'plan' => $plan,
            'selectedPlan' => $data['plan'],
            'order' => $order,
            'subscription' => $subscription,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Verify Razorpay Payment
    |--------------------------------------------------------------------------
    */

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => [
                'required',
                'string',
            ],

            'razorpay_order_id' => [
                'required',
                'string',
            ],

            'razorpay_signature' => [
                'required',
                'string',
            ],
        ]);


        $subscriptionId = $request->session()->get(
            'selected_subscription_id'
        );

        if (! $subscriptionId) {

            return redirect()
                ->route('apartment.plans')
                ->withErrors([
                    'payment' => 'Your payment session has expired.',
                ]);
        }


        $subscription = Subscription::find($subscriptionId);

        if (
            ! $subscription ||
            $subscription->management_type !== 'apartment' ||
            $subscription->razorpay_order_id !==
                $request->razorpay_order_id
        ) {

            return redirect()
                ->route('apartment.plans')
                ->withErrors([
                    'payment' => 'Invalid payment information.',
                ]);
        }


        try {

            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );


            /*
            |--------------------------------------------------------------------------
            | Verify Signature
            |--------------------------------------------------------------------------
            */

            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' =>
                    $request->razorpay_order_id,

                'razorpay_payment_id' =>
                    $request->razorpay_payment_id,

                'razorpay_signature' =>
                    $request->razorpay_signature,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Activate Subscription
            |--------------------------------------------------------------------------
            */

            $subscription->update([
                'status' => 'active',
                'starts_at' => now(),
                'expires_at' => now()->addDays(
                    $subscription->duration_days
                ),
                'razorpay_payment_id' =>
                    $request->razorpay_payment_id,
                'razorpay_signature' =>
                    $request->razorpay_signature,
            ]);


            return redirect()->route(
                'apartment.onboarding'
            );

        } catch (\Throwable $e) {

            $subscription->update([
                'status' => 'failed',
            ]);


            return redirect()
                ->route('apartment.plans')
                ->withErrors([
                    'payment' =>
                        'Payment verification failed. Please try again.',
                ]);
        }
    }
}