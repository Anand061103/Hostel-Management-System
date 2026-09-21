<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HostelAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // User login nahi hai
        if (! $user) {
            return redirect()->route('login');
        }

        // Super Admin ko sabhi hostels ka access
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        // Warden ke paas hostel assigned nahi hai
        if ($user->role === 'warden' && ! $user->hostel_id) {
            abort(403, 'No hostel is assigned to this account.');
        }

        // Warden ko assigned hostel ka hi access
        if ($user->role === 'warden') {
            $hostel = $request->route('hostel');

            if ($hostel && (int) $hostel->id !== (int) $user->hostel_id) {
                abort(403, 'You do not have access to this hostel.');
            }
        }

        return $next($request);
    }
}
