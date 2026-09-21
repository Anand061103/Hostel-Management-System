<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create($data);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();

            $user = Auth::user();

            // Super Admin
            if ($user->role === 'superadmin') {
                return redirect()->route('dashboard');
            }

            // Warden
            if ($user->role === 'warden') {

                if (! $user->hostel_id) {
                    Auth::logout();

                    return redirect()
                        ->route('login')
                        ->withErrors([
                            'email' => 'No hostel is assigned to this warden account.',
                        ]);
                }

                return redirect()->route('dashboard');
            }

            // Unknown / incomplete role
            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'This account does not have a valid role.',
                ]);
        }

        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
