<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function profile()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'superadmin') {

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
        | Warden
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'warden') {

            if (!$user->hostel_id) {
                abort(403, 'No hostel is assigned to this account.');
            }

            $hostels = Hostel::where('id', $user->hostel_id)
                ->where('status', 'active')
                ->get();

            return view('owner.profile', compact(
                'user',
                'hostels'
            ));
        }


        /*
        |--------------------------------------------------------------------------
        | Invalid Role
        |--------------------------------------------------------------------------
        */

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
}