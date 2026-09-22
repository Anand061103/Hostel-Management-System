<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\BedAssignment;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BedController extends Controller
{
    /**
     * Get current hostel ID.
     */
    private function currentHostelId()
    {
        $user = Auth::user();

        if ($user->role === 'superadmin') {

            $hostelId = session('current_hostel_id');

            if (!$hostelId) {
                abort(403, 'Please select a hostel first.');
            }

            return $hostelId;
        }

        if ($user->role === 'warden') {

            if (!$user->hostel_id) {
                abort(403, 'No hostel is assigned to this account.');
            }

            return $user->hostel_id;
        }

        abort(403, 'Invalid user role.');
    }

    /**
     * Ensure bed belongs to current hostel.
     */
    private function ensureBedAccess(Bed $bed): void
    {
        $bed->loadMissing('room');

        if (!$bed->room) {
            abort(404, 'Room not found for this bed.');
        }

        $hostelId = $this->currentHostelId();

        if ((int) $bed->room->hostel_id !== (int) $hostelId) {
            abort(403, 'You do not have access to this bed.');
        }
    }

    /**
     * Display a listing of beds.
     */
    public function index(Request $request)
    {
        $hostelId = $this->currentHostelId();

        $beds = Bed::with([
            'room',
            'student',
            'currentAssignment',
        ])
            ->whereHas('room', function ($query) use ($hostelId) {
                $query->where('hostel_id', $hostelId);
            })
            ->when($request->search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'bed_number',
                        'like',
                        "%{$search}%"
                    )

                        ->orWhereHas('room', function ($roomQuery) use ($search) {
                            $roomQuery->where(
                                'room_number',
                                'like',
                                "%{$search}%"
                            );
                        })

                        ->orWhereHas('currentAssignment.student', function ($studentQuery) use ($search) {
                            $studentQuery->where(
                                'full_name',
                                'like',
                                "%{$search}%"
                            );
                        });

                });

            })
            ->when($request->status, function ($query, $status) {

                $query->where('status', $status);

            })
            ->latest()
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Hostel-specific counts
        |--------------------------------------------------------------------------
        */

        $hostelBeds = Bed::whereHas('room', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        });

        $totalBeds = (clone $hostelBeds)->count();

        $availableBeds = (clone $hostelBeds)
            ->where('status', 'available')
            ->count();

        $occupiedBeds = (clone $hostelBeds)
            ->where('status', 'occupied')
            ->count();

        $maintenanceBeds = (clone $hostelBeds)
            ->where('status', 'maintenance')
            ->count();


        return view('beds.index', compact(
            'beds',
            'totalBeds',
            'availableBeds',
            'occupiedBeds',
            'maintenanceBeds'
        ));
    }

    /**
     * Show the form for creating a new bed.
     */
    public function create()
    {
        $hostelId = $this->currentHostelId();

        $rooms = Room::where('hostel_id', $hostelId)
            ->where('status', 'active')
            ->orderBy('room_number')
            ->get();

        return view('beds.create', compact('rooms'));
    }

    /**
     * Store a newly created bed.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'room_id' => [
                'required',
                'exists:rooms,id',
            ],

            'bed_number' => [
                'required',
                'string',
                'max:50',
            ],

        ]);

        $hostelId = $this->currentHostelId();


        /*
        |--------------------------------------------------------------------------
        | Check Room Belongs To Current Hostel
        |--------------------------------------------------------------------------
        */

        $room = Room::where('id', $validated['room_id'])
            ->where('hostel_id', $hostelId)
            ->where('status', 'active')
            ->first();

        if (!$room) {
            abort(403, 'You do not have access to this room.');
        }


        /*
        |--------------------------------------------------------------------------
        | Check Duplicate Bed
        |--------------------------------------------------------------------------
        */

        $alreadyExists = Bed::where('room_id', $validated['room_id'])
            ->where('bed_number', $validated['bed_number'])
            ->exists();

        if ($alreadyExists) {

            return back()
                ->withInput()
                ->withErrors([
                    'bed_number' =>
                        'This bed already exists in the selected room.',
                ]);
        }


        Bed::create([
            'room_id' => $room->id,
            'bed_number' => $validated['bed_number'],
            'status' => 'available',
            'student_id' => null,
        ]);


        return redirect()
            ->route('beds.index')
            ->with(
                'success',
                'Bed added successfully.'
            );
    }

    /**
     * Display the specified bed.
     */
    public function show(string $id)
    {
        $bed = Bed::with([
            'room',
            'currentAssignment.student',
            'assignments.student',
        ])->findOrFail($id);

        $this->ensureBedAccess($bed);

        return view('beds.show', compact('bed'));
    }

    /**
     * Show the form for editing the specified bed.
     */
    public function edit(Bed $bed)
    {
        $this->ensureBedAccess($bed);

        $hostelId = $this->currentHostelId();

        $rooms = Room::where('hostel_id', $hostelId)
            ->where('status', 'active')
            ->orderBy('room_number')
            ->get();

        return view('beds.edit', compact(
            'bed',
            'rooms'
        ));
    }

    /**
     * Update the specified bed.
     */
    public function update(Request $request, Bed $bed)
    {
        $this->ensureBedAccess($bed);

        $validated = $request->validate([

            'room_id' => [
                'required',
                'exists:rooms,id',
            ],

            'bed_number' => [
                'required',
                'string',
                'max:50',
            ],

            'status' => [
                'required',
                'in:available,occupied,maintenance',
            ],

        ]);

        $hostelId = $this->currentHostelId();


        /*
        |--------------------------------------------------------------------------
        | New Room Must Belong To Current Hostel
        |--------------------------------------------------------------------------
        */

        $room = Room::where('id', $validated['room_id'])
            ->where('hostel_id', $hostelId)
            ->where('status', 'active')
            ->first();

        if (!$room) {
            abort(403, 'You do not have access to this room.');
        }


        /*
        |--------------------------------------------------------------------------
        | Check Duplicate Bed
        |--------------------------------------------------------------------------
        */

        $alreadyExists = Bed::where('room_id', $validated['room_id'])
            ->where('bed_number', $validated['bed_number'])
            ->where('id', '!=', $bed->id)
            ->exists();

        if ($alreadyExists) {

            return back()
                ->withInput()
                ->withErrors([
                    'bed_number' =>
                        'This bed already exists in the selected room.',
                ]);
        }


        $bed->update([
            'room_id' => $validated['room_id'],
            'bed_number' => $validated['bed_number'],
            'status' => $validated['status'],
        ]);


        return redirect()
            ->route('beds.show', $bed)
            ->with(
                'success',
                'Bed updated successfully.'
            );
    }

    /**
     * Remove the specified bed.
     */
    public function destroy(Bed $bed)
    {
        $this->ensureBedAccess($bed);

        // Occupied bed cannot be deleted
        if (
            $bed->status === 'occupied'
            || $bed->student_id !== null
        ) {

            return redirect()
                ->route('beds.index')
                ->with(
                    'error',
                    'Occupied bed cannot be deleted. Release the bed first.'
                );
        }

        $bed->delete();

        return redirect()
            ->route('beds.index')
            ->with(
                'success',
                'Bed deleted successfully.'
            );
    }

    /**
     * Show assign student form.
     */
    public function assign(Bed $bed)
    {
        $this->ensureBedAccess($bed);

        if (
            $bed->status !== 'available'
            || $bed->student_id !== null
        ) {

            return redirect()
                ->route('beds.show', $bed)
                ->with(
                    'error',
                    'This bed is not available for assignment.'
                );
        }

        $hostelId = $this->currentHostelId();


        /*
        |--------------------------------------------------------------------------
        | Students already assigned
        |--------------------------------------------------------------------------
        */

        $assignedStudentIds = BedAssignment::where(function ($query) {
            $query->whereNull('end_date')
                ->orWhereDate(
                    'end_date',
                    '>=',
                    now()->toDateString()
                );
        })
            ->pluck('student_id');


        /*
        |--------------------------------------------------------------------------
        | Only current hostel students
        |--------------------------------------------------------------------------
        */

        $students = Student::where('hostel_id', $hostelId)
            ->whereNotIn('id', $assignedStudentIds)
            ->orderBy('full_name')
            ->get();


        return view(
            'beds.assign',
            compact('bed', 'students')
        );
    }

    /**
     * Assign a student to the bed.
     */
    public function storeAssignment(
        Request $request,
        Bed $bed
    ) {

        $this->ensureBedAccess($bed);

        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
            ],

            'start_date' => [
                'required',
                'date',
            ],
        ]);

        $hostelId = $this->currentHostelId();


        /*
        |--------------------------------------------------------------------------
        | Student Must Belong To Current Hostel
        |--------------------------------------------------------------------------
        */

        $student = Student::where('id', $validated['student_id'])
            ->where('hostel_id', $hostelId)
            ->first();

        if (!$student) {

            throw ValidationException::withMessages([
                'student_id' => [
                    'You cannot assign a student from another hostel.',
                ],
            ]);
        }


        DB::transaction(function () use (
            $bed,
            $validated
        ) {

            // Lock bed while assigning
            $bed = Bed::where('id', $bed->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Make sure bed is still available
            if (
                $bed->status !== 'available'
                || $bed->student_id !== null
            ) {

                throw ValidationException::withMessages([
                    'student_id' => [
                        'This bed is no longer available.',
                    ],
                ]);
            }


            // Check whether student already has an active bed
            $alreadyAssigned = BedAssignment::where(
                'student_id',
                $validated['student_id']
            )
                ->where(function ($query) {

                    $query->whereNull('end_date')
                        ->orWhereDate(
                            'end_date',
                            '>=',
                            now()->toDateString()
                        );

                })
                ->exists();

            if ($alreadyAssigned) {

                throw ValidationException::withMessages([
                    'student_id' => [
                        'This student is already assigned to an active bed.',
                    ],
                ]);
            }


            // Create assignment history
            BedAssignment::create([
                'bed_id' => $bed->id,
                'student_id' => $validated['student_id'],
                'start_date' => $validated['start_date'],
                'end_date' => null,
            ]);


            // Update current bed state
            $bed->update([
                'student_id' => $validated['student_id'],
                'status' => 'occupied',
            ]);
        });


        return redirect()
            ->route('beds.show', $bed)
            ->with(
                'success',
                'Student assigned to bed successfully.'
            );
    }
}