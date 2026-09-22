<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function profile()
{
    $user = Auth::user();

    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN
    |--------------------------------------------------------------------------
    */

    if ($user->role === 'superadmin') {

        // Admin is currently inside a hostel
        if (session('current_hostel_id')) {

            $hostel = Hostel::findOrFail(
                session('current_hostel_id')
            );

            // Find warden of this hostel
           $warden = User::where('role', 'warden')
                ->where('hostel_id', $hostel->id)
                ->first();

            return view('warden.profile', compact(
                'warden',
                'hostel'
            ));
                    }


        // Admin Global Profile

        $hostels = Hostel::where('status', 'active')
            ->latest()
            ->get();

        return view('owner.profile', compact(
            'user',
            'hostels'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | WARDEN
    |--------------------------------------------------------------------------
    */

    if ($user->role === 'warden') {

        if (!$user->hostel_id) {
            abort(403, 'No hostel is assigned to this account.');
        }

        $hostel = $user->hostel;

        return view('warden.profile', compact(
            'user',
            'hostel'
        ));
    }


    abort(403, 'Invalid user role.');
}


    public function enterHostel(Hostel $hostel)
    {
        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'superadmin') {

            if ($hostel->status !== 'active') {
                abort(403, 'This hostel is inactive.');
            }

            session([
                'current_hostel_id' => $hostel->id,
            ]);

            return redirect()->route('hostel.dashboard');
        }


        /*
        |--------------------------------------------------------------------------
        | Warden
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'warden') {

            if (!$user->hostel_id) {
                abort(403, 'No hostel is assigned to this account.');
            }

            if ((int) $user->hostel_id !== (int) $hostel->id) {
                abort(403, 'You do not have access to this hostel.');
            }

            if ($hostel->status !== 'active') {
                abort(403, 'This hostel is inactive.');
            }

            session([
                'current_hostel_id' => $hostel->id,
            ]);

            return redirect()->route('hostel.dashboard');
        }


        /*
        |--------------------------------------------------------------------------
        | Invalid Role
        |--------------------------------------------------------------------------
        */

        abort(403, 'Invalid user role.');
    }

    public function exitHostel()
{
    $user = Auth::user();

    if ($user->role !== 'superadmin') {
        abort(403, 'You are not allowed to access the global panel.');
    }

    session()->forget('current_hostel_id');

    return redirect()->route('dashboard');
}


          public function switchHostel()
{
    $user = Auth::user();

    if ($user->role !== 'superadmin') {
        abort(403, 'You are not allowed to switch hostels.');
    }

    $hostels = Hostel::where('status', 'active')
        ->orderBy('name')
        ->get();

    return view('owner.switch-hostel', compact('hostels'));
}
         

}