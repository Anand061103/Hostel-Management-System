<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\User;
use Illuminate\Http\Request;

class WardenController extends Controller
{
    public function create()
    {
        $hostels = Hostel::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('wardens.create', compact('hostels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'hostel_id' => ['required', 'exists:hostels,id'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'warden',
            'hostel_id' => $validated['hostel_id'],
        ]);

        return redirect()
            ->route('wardens.create')
            ->with('success', 'Warden created and hostel assigned successfully.');
    }
}
