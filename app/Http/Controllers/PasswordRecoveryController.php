<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordRecoveryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Forgot Password Form
    |--------------------------------------------------------------------------
    */

    public function showForgotForm()
    {
        return view('auth.password-forgot');
    }


    /*
    |--------------------------------------------------------------------------
    | Send Password Reset Link
    |--------------------------------------------------------------------------
    */

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {

            return back()->with(
                'status',
                'Password reset link has been sent to your email.'
            );
        }

        return back()
            ->withErrors([
                'email' => __($status),
            ])
            ->onlyInput('email');
    }


    /*
    |--------------------------------------------------------------------------
    | Show Reset Password Form
    |--------------------------------------------------------------------------
    */

    public function showResetForm(
        string $token,
        Request $request
    ) {
        return view('auth.password-reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Reset Password
    |--------------------------------------------------------------------------
    */

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => [
                'required',
            ],

            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),

            function ($user, $password) {

                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {

            return redirect()
                ->route('login')
                ->with(
                    'status',
                    'Your password has been reset successfully. You can now login with your new password.'
                );
        }

        return back()
            ->withErrors([
                'email' => __($status),
            ])
            ->withInput(
                $request->only('email')
            );
    }
}