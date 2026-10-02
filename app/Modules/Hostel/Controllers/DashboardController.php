<?php

namespace App\Modules\Hostel\Controllers;

use App\Http\Controllers\Controller;
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
        | Super Admin
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'superadmin') {

            // Admin is inside a selected hostel
            if (session('current_hostel_id')) {

                $hostel = Hostel::findOrFail(
                    session('current_hostel_id')
                );

                return view('dashboard.hostel', compact(
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

            return view('dashboard.index', compact(
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

            return view('dashboard.hostel', compact(
                'user',
                'hostel'
            ));
        }

        abort(403, 'Invalid user role.');
    }
}