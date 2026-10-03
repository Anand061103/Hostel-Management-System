<?php

namespace App\Modules\Hostel\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Modules\Hostel\Models\Bed;
use App\Modules\Hostel\Models\Fee;
use App\Modules\Hostel\Models\FeePayment;
use App\Modules\Hostel\Models\Hostel;
use App\Modules\Hostel\Models\Room;
use App\Modules\Hostel\Models\Student;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();


        /*
|--------------------------------------------------------------------------
| Owner
|--------------------------------------------------------------------------
*/

if ($user->role === 'owner') {

    $subscription = Subscription::where('user_id', $user->id)
        ->where('status', 'active')
        ->where('expires_at', '>', now())
        ->latest('id')
        ->first();

    if (! $subscription) {

        return redirect()
            ->route('hostel.plans')
            ->withErrors([
                'plan' => 'Your subscription has expired. Please select a plan to continue.',
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | 7 Days Free Trial
    |--------------------------------------------------------------------------
    |
    | Trial mein Owner Panel milega.
    |
    */

    if ($subscription->plan === 'trial') {

        return view('owner.dashboard.index', compact(
            'user',
            'subscription'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | ₹399
    |--------------------------------------------------------------------------
    |
    | ₹399 plan mein Warden-style single hostel panel.
    |
    */

    if ($subscription->plan === '399') {

        $hostel = $user->hostel;

        if (! $hostel) {
            abort(403, 'No hostel is assigned to this owner account.');
        }

        return view('hostel.dashboard.index', compact(
            'user',
            'hostel',
            'subscription'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | ₹999
    |--------------------------------------------------------------------------
    |
    | ₹999 plan mein Multi-Hostel Owner Panel.
    |
    */

    if ($subscription->plan === '999') {

        return view('owner.dashboard.index', compact(
            'user',
            'subscription'
        ));
    }

    abort(403, 'Invalid subscription plan.');
}



        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'superadmin') {

            // Admin is inside a selected hostel
            if (session('current_hostel_id')) {

                $hostel = Hostel::findOrFail(
                    session('current_hostel_id')
                );

                return view('hostel.dashboard.index', compact(
                    'user',
                    'hostel'
                ));
            }

            // Admin Global Dashboard

            $totalHostels = Hostel::where('status', 'active')->count();

            $totalStudents = Student::count();

            $totalRooms = Room::count();

            $totalBeds = Bed::count();

            $totalFeeAmount = Fee::sum('amount');

            $totalPaid = FeePayment::sum('amount');

            $totalOutstanding = max(
                0,
                $totalFeeAmount - $totalPaid
            );

            return view('owner.dashboard.index', compact(
                'user',
                'totalHostels',
                'totalStudents',
                'totalRooms',
                'totalBeds',
                'totalFeeAmount',
                'totalPaid',
                'totalOutstanding'
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | Warden
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'warden') {

            $hostel = $user->hostel;

            if (!$hostel) {
                abort(403, 'No hostel is assigned to this account.');
            }

            return view('hostel.dashboard.index', compact(
                'user',
                'hostel'
            ));
        }

        abort(403, 'Invalid user role.');
    }
}