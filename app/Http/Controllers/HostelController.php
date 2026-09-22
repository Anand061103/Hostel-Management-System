<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HostelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hostels = Hostel::latest()->get();

        return view('hostels.index', compact('hostels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hostels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        // Hostel Details
        'name' => ['required', 'string', 'max:255'],
        'address' => ['nullable', 'string'],
        'phone' => ['nullable', 'string', 'max:20'],
        'email' => ['nullable', 'email', 'max:255'],

        // Warden Details
        'warden_name' => ['required', 'string', 'max:255'],
        'warden_email' => ['required', 'email', 'unique:users,email'],
        'warden_password' => ['required', 'confirmed', 'min:8'],
        'warden_mobile_number' => ['required', 'string', 'max:15'],
        'warden_address' => ['nullable', 'string'],
        'warden_joining_date' => ['nullable', 'date'],
        'warden_photo' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
    ]);

    DB::transaction(function () use ($request, $validated) {

        // Create Hostel
        $hostel = Hostel::create([
            'name' => $validated['name'],
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
        ]);

        // Upload Warden Photo
        $photo = null;

        if ($request->hasFile('warden_photo')) {
            $photo = $request->file('warden_photo')
                ->store('wardens', 'public');
        }

        // Create Warden User
        User::create([
            'name' => $validated['warden_name'],
            'email' => $validated['warden_email'],
            'password' => $validated['warden_password'],
            'role' => 'warden',
            'hostel_id' => $hostel->id,
            'mobile_number' => $validated['warden_mobile_number'],
            'address' => $validated['warden_address'] ?? null,
            'photo' => $photo,
            'joining_date' => $validated['warden_joining_date'] ?? null,
        ]);
    });

    return redirect()
        ->route('hostels.index')
        ->with('success', 'Hostel and warden created successfully.');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
