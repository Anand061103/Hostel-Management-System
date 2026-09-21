<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Hostel;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Super Admin / Owner
        if ($user->role === 'superadmin') {

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

        // Warden
        if ($user->role === 'warden') {

            $hostel = $user->hostel;

            if (! $hostel) {
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
