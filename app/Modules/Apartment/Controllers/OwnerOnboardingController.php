<?php

namespace App\Modules\Apartment\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use App\Modules\Apartment\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class OwnerOnboardingController extends Controller
{
    /**
     * Show apartment onboarding page.
     */
    public function index(Request $request)
    {
        if (! $request->session()->has('signup_data')) {
            return redirect()->route('signup');
        }

        if (! $request->session()->has('selected_subscription_id')) {
            return redirect()
                ->route('apartment.plans')
                ->withErrors([
                    'plan' => 'Please select an apartment plan first.',
                ]);
        }

        return view('apartment.onboarding.index');
    }


    /**
     * Create owner account and apartment.
     */
    public function store(Request $request)
    {
        if (! $request->session()->has('signup_data')) {
            return redirect()->route('signup');
        }

        $subscriptionId = $request->session()
            ->get('selected_subscription_id');

        if (! $subscriptionId) {
            return redirect()
                ->route('apartment.plans')
                ->withErrors([
                    'plan' => 'Please select an apartment plan first.',
                ]);
        }

        $subscription = Subscription::find($subscriptionId);

        if (
            ! $subscription ||
            $subscription->management_type !== 'apartment' ||
            ! $subscription->isActive()
        ) {
            return redirect()
                ->route('apartment.plans')
                ->withErrors([
                    'plan' => 'Your apartment subscription is invalid or expired.',
                ]);
        }


        $data = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'address' => [
                'required',
                'string',
                'max:1000',
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
                'digits:6',
            ],

            'type' => [
                'required',
                'in:Apartment Society,Gated Community,Residential Complex,Builder Apartment,Other',
            ],

        ]);


        $signupData = $request->session()->get('signup_data');


        DB::transaction(function () use (
            $request,
            $data,
            $signupData,
            $subscription
        ) {

            /*
             * Create Owner Account
             */
            $user = User::create([

                'name' => $signupData['name'],

                'email' => $signupData['email'],

                'password' => $signupData['password'],

                'role' => 'owner',

                'management_type' => 'apartment',

                'mobile_number' => $signupData['mobile_number'],

                'pan_number' => $signupData['pan_number'],

                'bank_account_holder_name' =>
                    $signupData['bank_account_holder_name'],

                'account_number' =>
                    $signupData['account_number'],

                'ifsc_code' =>
                    $signupData['ifsc_code'],

            ]);


            /*
             * Store Property Photo
             */
            $photoPath = null;

            if ($request->hasFile('photo')) {

                $photoPath = $request
                    ->file('photo')
                    ->store('apartments', 'public');

            }


            /*
             * Create Apartment
             */
            $apartment = Apartment::create([

                'owner_id' => $user->id,

                'name' => $data['name'],

                'photo' => $photoPath,

                'address' => $data['address'],

                'city' => $data['city'],

                'state' => $data['state'],

                'pincode' => $data['pincode'],

                'type' => $data['type'],

                'status' => 'active',

            ]);


            /*
             * Attach Subscription to Owner
             */
            $subscription->update([

                'user_id' => $user->id,

            ]);

        });


        /*
         * Clear onboarding session data
         */
        $request->session()->forget([
            'signup_data',
            'selected_apartment_plan',
            'selected_subscription_id',
        ]);


        return redirect()
            ->route('login')
            ->with(
                'success',
                'Apartment account created successfully. Please login to continue.'
            );
    }
}