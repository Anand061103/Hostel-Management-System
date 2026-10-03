<?php

namespace App\Http\Controllers;

use App\Modules\Hostel\Models\Hostel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

        // existing code...
    }


    /*
    |--------------------------------------------------------------------------
    | OWNER
    |--------------------------------------------------------------------------
    */

    if ($user->role === 'owner') {

        $hostels = Hostel::where('owner_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('owner.profile.index', compact(
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

        // existing code...
    }


    abort(403, 'Invalid user role.');
}


  public function editWardenProfile()
{
    $user = Auth::user();

    if ($user->role !== 'warden') {
        abort(403, 'Only wardens can access this page.');
    }

    if (!$user->hostel_id) {
        abort(403, 'No hostel is assigned to this account.');
    }

    $warden = $user;
    $hostel = $user->hostel;

    return view('hostel.warden.profile-edit', compact(
        'warden',
        'hostel'
    ));
}

public function updateWardenProfile(Request $request)
{
    $user = Auth::user();

    if ($user->role !== 'warden') {
        abort(403, 'Only wardens can update this profile.');
    }

    $validated = $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
        ],

        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')
                ->ignore($user->id),
        ],

        'mobile_number' => [
            'nullable',
            'string',
            'max:15',
        ],

        'address' => [
            'nullable',
            'string',
            'max:1000',
        ],

        'photo' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
    ]);


    /*
    |--------------------------------------------------------------------------
    | Update Basic Information
    |--------------------------------------------------------------------------
    */

    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->mobile_number = $validated['mobile_number'] ?? null;
    $user->address = $validated['address'] ?? null;


    /*
    |--------------------------------------------------------------------------
    | Update Profile Photo
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('photo')) {

        // Delete old photo
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        // Store new photo
        $user->photo = $request
            ->file('photo')
            ->store('wardens', 'public');
    }


    $user->save();


    return redirect()
        ->route('profile')
        ->with('success', 'Profile updated successfully.');
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
         

   public function editProfile()
{
    $user = Auth::user();

    if ($user->role !== 'superadmin') {
        abort(403, 'Only Super Admin can edit this profile.');
    }

    return view('owner.profile.edit', compact('user'));
}

public function updateProfile(Request $request)
{
   /** @var \App\Models\User $user */
$user = Auth::user();

    // Only Super Admin can update this profile
    if ($user->role !== 'superadmin') {
        abort(403, 'Only Super Admin can update this profile.');
    }

    $validated = $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
        ],

        'mobile_number' => [
            'nullable',
            'string',
            'max:20',
        ],

        'address' => [
            'nullable',
            'string',
            'max:1000',
        ],

        'joining_date' => [
            'nullable',
            'date',
        ],

        'photo' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Profile Photo
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('photo')) {

        // Delete old photo
        if (
            $user->photo &&
            Storage::disk('public')->exists($user->photo)
        ) {
            Storage::disk('public')->delete($user->photo);
        }

        // Store new photo
        $validated['photo'] = $request
            ->file('photo')
            ->store('profile-photos', 'public');
    }


    /*
    |--------------------------------------------------------------------------
    | Update User
    |--------------------------------------------------------------------------
    */

    $user->update($validated);


    return redirect()
        ->route('profile')
        ->with(
            'success',
            'Your profile has been updated successfully.'
        );
}




          public function editEmail()
{
    $user = Auth::user();

    if ($user->role !== 'superadmin') {
        abort(403, 'Only Super Admin can change this email.');
    }

    return view('owner.profile.change-email', compact('user'));
}


public function updateEmail(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->role !== 'superadmin') {
        abort(403, 'Only Super Admin can change this email.');
    }

    $validated = $request->validate([
        'current_password' => [
            'required',
        ],

        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users', 'email')->ignore($user->id),
        ],

        'email_confirmation' => [
            'required',
            'same:email',
        ],
    ]);


    /*
    |--------------------------------------------------------------------------
    | Verify Current Password
    |--------------------------------------------------------------------------
    */

    if (! Hash::check($validated['current_password'], $user->password)) {

        return back()
            ->withErrors([
                'current_password' => 'Your current password is incorrect.',
            ])
            ->withInput();
    }


    /*
    |--------------------------------------------------------------------------
    | Update Email
    |--------------------------------------------------------------------------
    */

    $user->email = $validated['email'];

    // New email must be verified again
    $user->email_verified_at = null;

    $user->save();


    return redirect()
        ->route('profile')
        ->with(
            'success',
            'Your email address has been updated successfully.'
        );
}
         

      /*
|--------------------------------------------------------------------------
| Change Password
|--------------------------------------------------------------------------
*/

public function editPassword()
{
    $user = Auth::user();

    return view('owner.profile.change-password', compact('user'));
}


public function updatePassword(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'current_password' => ['required'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ], [
        'current_password.required' => 'Please enter your current password.',
        'password.required' => 'Please enter a new password.',
        'password.min' => 'New password must be at least 8 characters.',
        'password.confirmed' => 'New password confirmation does not match.',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Verify Current Password
    |--------------------------------------------------------------------------
    */

    if (! Hash::check($validated['current_password'], $user->password)) {

        return back()
            ->withErrors([
                'current_password' => 'Your current password is incorrect.',
            ])
            ->withInput();

    }


    /*
    |--------------------------------------------------------------------------
    | Update Password
    |--------------------------------------------------------------------------
    */

    $user->update([
        'password' => $validated['password'],
    ]);


    /*
    |--------------------------------------------------------------------------
    | Success
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('profile')
        ->with('success', 'Your password has been changed successfully.');
}





}