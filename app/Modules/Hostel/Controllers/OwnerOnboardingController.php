<?php

namespace App\Modules\Hostel\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Modules\Hostel\Models\Hostel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OwnerOnboardingController
{
    /*
    |--------------------------------------------------------------------------
    | Show Onboarding Page
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Signup data check
        |--------------------------------------------------------------------------
        */

        if (! $request->session()->has('signup_data')) {
            return redirect()->route('signup');
        }


        /*
        |--------------------------------------------------------------------------
        | Selected subscription check
        |--------------------------------------------------------------------------
        */

        if (! $request->session()->has('selected_subscription_id')) {
            return redirect()->route('hostel.plans');
        }


        return view('hostel.onboarding.index');
    }


    /*
    |--------------------------------------------------------------------------
    | Create Owner Account
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Get Temporary Signup Data
        |--------------------------------------------------------------------------
        */

        $signupData = $request->session()->get('signup_data');

        if (! $signupData) {
            return redirect()->route('signup');
        }


        /*
        |--------------------------------------------------------------------------
        | Get Subscription
        |--------------------------------------------------------------------------
        */

        $subscriptionId = $request->session()->get(
            'selected_subscription_id'
        );

        if (! $subscriptionId) {
            return redirect()->route('hostel.plans');
        }


        $subscription = Subscription::find($subscriptionId);

        if (! $subscription) {
            return redirect()->route('hostel.plans')
                ->withErrors([
                    'plan' => 'Your selected plan could not be found.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Hostel Details
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'address' => [
                'required',
                'string',
                'max:2000',
            ],

            'city' => [
                'required',
                'string',
                'max:100',
            ],

            'state' => [
                'required',
                'string',
                'max:100',
            ],

            'pincode' => [
                'required',
                'string',
                'max:10',
            ],

            'type' => [
                'required',
                'string',
                'max:100',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Create Everything Inside Transaction
        |--------------------------------------------------------------------------
        */

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Create Owner
            |--------------------------------------------------------------------------
            */

            $user = User::create([

                'name' =>
                    $signupData['name'],

                'email' =>
                    $signupData['email'],

                'password' =>
                    $signupData['password'],

                'role' =>
                    'owner',

                'mobile_number' =>
                    $signupData['mobile_number'],

                'management_type' =>
                    'hostel',

                'pan_number' =>
                    $signupData['pan_number'],

                'bank_account_holder_name' =>
                    $signupData['bank_account_holder_name'],

                'account_number' =>
                    $signupData['account_number'],

                'ifsc_code' =>
                    $signupData['ifsc_code'],

            ]);


            /*
            |--------------------------------------------------------------------------
            | Upload Hostel Photo
            |--------------------------------------------------------------------------
            */

            $photoPath = $request
                ->file('photo')
                ->store('hostels', 'public');


            /*
            |--------------------------------------------------------------------------
            | Create Hostel
            |--------------------------------------------------------------------------
            */

            $hostel = Hostel::create([

                'owner_id' =>
                    $user->id,

                'name' =>
                    $data['name'],

                'photo' =>
                    $photoPath,

                'address' =>
                    $data['address'],

                'city' =>
                    $data['city'],

                'state' =>
                    $data['state'],

                'pincode' =>
                    $data['pincode'],

                'type' =>
                    $data['type'],

                'status' =>
                    'active',

            ]);


            /*
            |--------------------------------------------------------------------------
            | Attach Hostel To Owner
            |--------------------------------------------------------------------------
            */

            $user->update([
                'hostel_id' => $hostel->id,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Attach Subscription To Owner
            |--------------------------------------------------------------------------
            */

            $subscription->update([
                'user_id' => $user->id,
            ]);


            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | Remove Temporary Signup Data
            |--------------------------------------------------------------------------
            */

            $request->session()->forget([
                'signup_data',
                'selected_hostel_plan',
                'selected_subscription_id',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Account Created
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Your account has been created successfully. Please login to continue.'
                );


        } catch (\Throwable $e) {

            DB::rollBack();


            /*
            |--------------------------------------------------------------------------
            | Delete Uploaded Photo If Account Creation Failed
            |--------------------------------------------------------------------------
            */

            if (
                isset($photoPath)
                && Storage::disk('public')->exists($photoPath)
            ) {
                Storage::disk('public')->delete($photoPath);
            }


            return back()
                ->withInput()
                ->withErrors([
                    'account' =>
                        'Unable to create your account. Please try again.',
                ]);
        }
    }
}