<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Signup
    |--------------------------------------------------------------------------
    */

    public function signup(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'mobile_number' => [
                'required',
                'string',
                'max:20',
            ],

            'management_type' => [
                'required',
                'in:hostel,apartment',
            ],

            'pan_number' => [
                'required',
                'string',
                'size:10',
                'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            ],

            'bank_account_holder_name' => [
                'required',
                'string',
                'max:255',
            ],

            'bank_account_number' => [
                'required',
                'string',
                'min:8',
                'max:30',
            ],

            'bank_account_number_confirmation' => [
                'required',
                'same:bank_account_number',
            ],

            'ifsc_code' => [
                'required',
                'string',
                'size:11',
                'regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            ],

            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Store Signup Data Temporarily
        |--------------------------------------------------------------------------
        |
        | Account abhi create nahi hoga.
        | Data session mein temporarily rahega.
        |
        */

        $request->session()->put('signup_data', [
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_number' => $data['mobile_number'],
            'management_type' => $data['management_type'],

            'pan_number' => strtoupper($data['pan_number']),

            'bank_account_holder_name' =>
                $data['bank_account_holder_name'],

            'account_number' =>
                $data['bank_account_number'],

            'ifsc_code' =>
                strtoupper($data['ifsc_code']),

            'password' =>
                $data['password'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect According To Management Type
        |--------------------------------------------------------------------------
        */

        if ($data['management_type'] === 'hostel') {

            return redirect()->route('hostel.plans');

        }

        if ($data['management_type'] === 'apartment') {

            return redirect()->route('apartment.plans');

        }


        return redirect()->route('signup');
    }


    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
            ],
        ]);


        if (Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {

            $request->session()->regenerate();

            $user = Auth::user();


            /*
            |--------------------------------------------------------------------------
            | Owner
            |--------------------------------------------------------------------------
            */

            if ($user->role === 'owner') {

                /*
                | Hostel owner
                */

                if ($user->management_type === 'hostel') {

                    return redirect()->route('hostel.dashboard');
                }


                /*
                | Apartment owner
                */

                if ($user->management_type === 'apartment') {

                    return redirect()->route('apartment.dashboard');
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Super Admin
            |--------------------------------------------------------------------------
            */

            if ($user->role === 'superadmin') {

                return redirect()->route('dashboard');
            }


            /*
            |--------------------------------------------------------------------------
            | Warden
            |--------------------------------------------------------------------------
            */

            if ($user->role === 'warden') {

                if (! $user->hostel_id) {

                    Auth::logout();

                    return redirect()
                        ->route('login')
                        ->withErrors([
                            'email' =>
                                'No hostel is assigned to this warden account.',
                        ]);
                }

                return redirect()->route('dashboard');
            }


            /*
            |--------------------------------------------------------------------------
            | Unknown / Invalid Role
            |--------------------------------------------------------------------------
            */

            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'This account does not have a valid role.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Login Failed
        |--------------------------------------------------------------------------
        */

        return back()
            ->withErrors([
                'email' =>
                    'The provided credentials do not match our records.',
            ])
            ->onlyInput('email');
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}