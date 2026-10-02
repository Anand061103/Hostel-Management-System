<?php

namespace App\Modules\Hostel\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Throwable;

class HostelPlanController
{
    /*
    |--------------------------------------------------------------------------
    | Show Hostel Plans
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        if (! $request->session()->has('signup_data')) {
            return redirect()->route('signup');
        }

        return view('hostel.plans.index');
    }


    /*
    |--------------------------------------------------------------------------
    | Select Hostel Plan
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

        $plan = $data['plan'];

        $planDetails = config("hostel.plans.{$plan}");

        if (! $planDetails) {
            return back()->withErrors([
                'plan' => 'Invalid plan selected.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | FREE TRIAL
        |--------------------------------------------------------------------------
        */

        if ($plan === 'trial') {

            $subscription = Subscription::create([
                'user_id' => null,
                'management_type' => 'hostel',
                'plan' => 'trial',
                'amount' => 0,
                'duration_days' => 7,
                'status' => 'active',
                'starts_at' => now(),
                'expires_at' => now()->addDays(7),
            ]);

            $request->session()->put(
                'selected_subscription_id',
                $subscription->id
            );

            $request->session()->put(
                'selected_hostel_plan',
                'trial'
            );

            return redirect()->route('hostel.onboarding');
        }


        /*
        |--------------------------------------------------------------------------
        | PAID PLAN
        |--------------------------------------------------------------------------
        */

        try {

            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );


            // ₹399 / ₹999 → paise
            $amountInPaise = $planDetails['amount'] * 100;


            $order = $api->order->create([
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'receipt' => 'hostel_plan_' . uniqid(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | Save Pending Subscription
            |--------------------------------------------------------------------------
            */

            $subscription = Subscription::create([
                'user_id' => null,
                'management_type' => 'hostel',
                'plan' => $plan,
                'amount' => $planDetails['amount'],
                'duration_days' => $planDetails['duration_days'],
                'status' => 'pending',
                'razorpay_order_id' => $order['id'],
            ]);


            /*
            |--------------------------------------------------------------------------
            | Save Session
            |--------------------------------------------------------------------------
            */

            $request->session()->put(
                'selected_subscription_id',
                $subscription->id
            );

            $request->session()->put(
                'selected_hostel_plan',
                $plan
            );


            /*
            |--------------------------------------------------------------------------
            | Razorpay Checkout
            |--------------------------------------------------------------------------
            */

            return view('hostel.plans.checkout', [
                'orderId' => $order['id'],
                'amount' => $amountInPaise,
                'plan' => $plan,
                'planName' => $planDetails['name'],
                'planAmount' => $planDetails['amount'],
                'key' => config('services.razorpay.key'),
                'signupData' => $request->session()->get('signup_data'),
            ]);

        } catch (Throwable $e) {

            return back()
                ->withErrors([
                    'payment' =>
                        'Unable to start payment. Please try again.',
                ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Verify Razorpay Payment
    |--------------------------------------------------------------------------
    */

    public function verifyPayment(Request $request)
    {
        if (! $request->session()->has('signup_data')) {
            return redirect()->route('signup');
        }


        $data = $request->validate([
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
                ->route('hostel.plans')
                ->withErrors([
                    'payment' =>
                        'Payment session expired. Please select the plan again.',
                ]);
        }


        $subscription = Subscription::find($subscriptionId);


        if (! $subscription) {

            return redirect()
                ->route('hostel.plans')
                ->withErrors([
                    'payment' =>
                        'Subscription record not found.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Make sure order belongs to our subscription
        |--------------------------------------------------------------------------
        */

        if (
            $subscription->razorpay_order_id
            !== $data['razorpay_order_id']
        ) {

            return redirect()
                ->route('hostel.plans')
                ->withErrors([
                    'payment' =>
                        'Invalid payment order.',
                ]);
        }


        try {

            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );


            /*
            |--------------------------------------------------------------------------
            | Razorpay Signature Verification
            |--------------------------------------------------------------------------
            */

            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' =>
                    $data['razorpay_order_id'],

                'razorpay_payment_id' =>
                    $data['razorpay_payment_id'],

                'razorpay_signature' =>
                    $data['razorpay_signature'],
            ]);


            /*
            |--------------------------------------------------------------------------
            | Payment Verified
            |--------------------------------------------------------------------------
            */

            $subscription->update([
                'status' => 'active',

                'starts_at' => now(),

                'expires_at' => now()->addDays(
                    $subscription->duration_days
                ),

                'razorpay_payment_id' =>
                    $data['razorpay_payment_id'],

                'razorpay_signature' =>
                    $data['razorpay_signature'],
            ]);


            return redirect()->route(
                'hostel.onboarding'
            );

        } catch (Throwable $e) {

            $subscription->update([
                'status' => 'failed',
            ]);


            return redirect()
                ->route('hostel.plans')
                ->withErrors([
                    'payment' =>
                        'Payment verification failed. Please try again.',
                ]);
        }
    }
}