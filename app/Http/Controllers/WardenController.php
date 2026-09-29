<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class WardenController extends Controller
{
    /**
     * Display a listing of the wardens.
     */
 public function index(Request $request)
{
    $query = User::where('role', 'warden')
        ->with('hostel');

    // Search by name or email
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Filter by hostel
    if ($request->filled('hostel_id')) {
        $query->where('hostel_id', $request->hostel_id);
    }

    $wardens = $query
    ->latest()
    ->paginate(10)
    ->withQueryString();

    // Summary cards
    $totalWardens = User::where('role', 'warden')->count();

    $assignedWardens = User::where('role', 'warden')
        ->whereNotNull('hostel_id')
        ->count();

    $unassignedWardens = User::where('role', 'warden')
        ->whereNull('hostel_id')
        ->count();

    $activeHostels = Hostel::where('status', 'active')->count();

    // Hostel filter options
    $hostels = Hostel::where('status', 'active')
        ->orderBy('name')
        ->get();

    return view('wardens.index', compact(
        'wardens',
        'totalWardens',
        'assignedWardens',
        'unassignedWardens',
        'activeHostels',
        'hostels'
    ));
}


    /**
     * Show the form for creating a new warden.
     */
   public function create()
{
    $assignedHostelIds = User::where('role', 'warden')
        ->whereNotNull('hostel_id')
        ->pluck('hostel_id');

    $hostels = Hostel::where('status', 'active')
        ->whereNotIn('id', $assignedHostelIds)
        ->orderBy('name')
        ->get();

    return view('wardens.create', compact('hostels'));
}

    /**
     * Store a newly created warden.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],

        'email' => [
            'required',
            'email',
            'unique:users,email',
        ],

        'password' => [
            'required',
            'confirmed',
            'min:8',
        ],

        'hostel_id' => [
            'required',
            'exists:hostels,id',
            Rule::unique('users', 'hostel_id')
                ->where(function ($query) {
                    return $query->where('role', 'warden');
                }),
        ],

        'mobile_number' => [
            'required',
            'string',
            'max:20',
        ],

        'joining_date' => [
            'nullable',
            'date',
        ],

        'address' => [
            'nullable',
            'string',
            'max:1000',
        ],

        'aadhaar_number' => [
            'required',
            'string',
            'max:20',
        ],

        'account_number' => [
            'required',
            'string',
            'max:30',
        ],
        'ifsc_code' => [
            'required',
            'string',
            'max:20',
        ],

        'photo' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
    ]);

    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')->store('wardens', 'public');
    }

    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'],
        'role' => 'warden',
        'hostel_id' => $validated['hostel_id'],
        'mobile_number' => $validated['mobile_number'],
        'joining_date' => $validated['joining_date'] ?? null,
        'address' => $validated['address'] ?? null,
        'aadhaar_number' => $validated['aadhaar_number'],
        'account_number' => $validated['account_number'],
        'ifsc_code' => $validated['ifsc_code'],
        'photo' => $validated['photo'] ?? null,
    ]);

    return redirect()
        ->route('wardens.index')
        ->with('success', 'Warden created and hostel assigned successfully.');
}


    /**
     * Display the specified warden.
     */
    public function show(User $warden)
    {
        abort_unless($warden->role === 'warden', 404);

        $warden->load('hostel');

        return view('wardens.show', compact('warden'));
    }


    /**
     * Show the form for editing the specified warden.
     */
   public function edit(User $warden)
{
    abort_unless($warden->role === 'warden', 404);

    // Other wardens ke assigned hostels
    $assignedHostelIds = User::where('role', 'warden')
        ->where('id', '!=', $warden->id)
        ->whereNotNull('hostel_id')
        ->pluck('hostel_id');

    // Active hostels + current warden ka hostel
    $hostels = Hostel::where('status', 'active')
        ->where(function ($query) use ($assignedHostelIds, $warden) {
            $query->whereNotIn('id', $assignedHostelIds)
                ->orWhere('id', $warden->hostel_id);
        })
        ->orderBy('name')
        ->get();

    return view('wardens.edit', compact('warden', 'hostels'));
}


    /**
     * Update the specified warden.
     */
   public function update(Request $request, User $warden)
{
    abort_unless($warden->role === 'warden', 404);

    $validated = $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
        ],

        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($warden->id),
        ],

        'hostel_id' => [
            'required',
            'exists:hostels,id',
            Rule::unique('users', 'hostel_id')
                ->where(function ($query) use ($warden) {
                    return $query
                        ->where('role', 'warden')
                        ->where('id', '!=', $warden->id);
                }),
        ],

        'mobile_number' => [
            'required',
            'string',
            'max:20',
        ],

        'joining_date' => [
            'nullable',
            'date',
        ],

        'address' => [
            'nullable',
            'string',
            'max:1000',
        ],

        'aadhaar_number' => [
            'required',
            'string',
            'max:20',
        ],

        'account_number' => [
            'required',
            'string',
            'max:30',
        ],
        'ifsc_code' => [
            'required',
            'string',
            'max:20',
        ],
        'photo' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],

        'password' => [
            'nullable',
            'confirmed',
            'min:8',
        ],
        
    ]);

    $warden->name = $validated['name'];
    $warden->email = $validated['email'];
    $warden->hostel_id = $validated['hostel_id'];
    $warden->mobile_number = $validated['mobile_number'];
    $warden->joining_date = $validated['joining_date'] ?? null;
    $warden->address = $validated['address'] ?? null;
    $warden->aadhaar_number = $validated['aadhaar_number'];
    $warden->account_number = $validated['account_number'];
    $warden->ifsc_code = $validated['ifsc_code'];

    // Change password only if entered
    if (!empty($validated['password'])) {
        $warden->password = $validated['password'];
    }

    // New photo
    if ($request->hasFile('photo')) {
        $warden->photo = $request->file('photo')->store('wardens', 'public');
    }

    $warden->save();

    return redirect()
        ->route('wardens.show', $warden)
        ->with('success', 'Warden updated successfully.');
}


    /**
     * Remove the specified warden.
     */
    public function destroy(User $warden)
    {
        abort_unless($warden->role === 'warden', 404);

        $warden->delete();

        return redirect()
            ->route('wardens.index')
            ->with(
                'success',
                'Warden deleted successfully.'
            );
    }
}