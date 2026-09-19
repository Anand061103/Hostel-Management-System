<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\BedAssignment;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $beds = Bed::with([
            'room',
            'student',
            'currentAssignment',
        ])
            ->when($request->search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('bed_number', 'like', "%{$search}%")

                        ->orWhereHas('room', function ($roomQuery) use ($search) {
                            $roomQuery->where(
                                'room_number',
                                'like',
                                "%{$search}%"
                            );
                        })

                        ->orWhereHas('student', function ($studentQuery) use ($search) {
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

        $totalBeds = Bed::count();

        $availableBeds = Bed::where('status', 'available')
            ->count();

        $occupiedBeds = Bed::where('status', 'occupied')
            ->count();

        $maintenanceBeds = Bed::where('status', 'maintenance')
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::where('status', 'active')
            ->orderBy('room_number')
            ->get();

        return view('beds.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
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

        $alreadyExists = Bed::where('room_id', $validated['room_id'])
            ->where('bed_number', $validated['bed_number'])
            ->exists();

        if ($alreadyExists) {

            return back()
                ->withInput()
                ->withErrors([
                    'bed_number' => 'This bed already exists in the selected room.',
                ]);
        }

        Bed::create([
            'room_id' => $validated['room_id'],
            'bed_number' => $validated['bed_number'],
            'status' => 'available',
            'student_id' => null,
        ]);

        return redirect()
            ->route('beds.index')
            ->with('success', 'Bed added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bed = Bed::with([
            'room',
            'currentAssignment.student',
            'assignments.student',
        ])->findOrFail($id);

        return view('beds.show', compact('bed'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bed $bed)
    {
        $rooms = Room::where('status', 'active')
            ->orderBy('room_number')
            ->get();

        return view('beds.edit', compact('bed', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bed $bed)
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

            'status' => [
                'required',
                'in:available,occupied,maintenance',
            ],
        ]);

        $alreadyExists = Bed::where('room_id', $validated['room_id'])
            ->where('bed_number', $validated['bed_number'])
            ->where('id', '!=', $bed->id)
            ->exists();

        if ($alreadyExists) {

            return back()
                ->withInput()
                ->withErrors([
                    'bed_number' => 'This bed already exists in the selected room.',
                ]);
        }

        $bed->update($validated);

        return redirect()
            ->route('beds.show', $bed)
            ->with('success', 'Bed updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bed $bed)
    {
        // Occupied bed cannot be deleted
        if ($bed->status === 'occupied' || $bed->student_id !== null) {
            return redirect()
                ->route('beds.index')
                ->with('error', 'Occupied bed cannot be deleted. Release the bed first.');
        }

        $bed->delete();

        return redirect()
            ->route('beds.index')
            ->with('success', 'Bed deleted successfully.');
    }

    /**
     * Show assign student form.
     */
    public function assign(Bed $bed)
    {
        if ($bed->status !== 'available' || $bed->student_id !== null) {
            return redirect()
                ->route('beds.show', $bed)
                ->with('error', 'This bed is not available for assignment.');
        }

        // Students who already have an active bed assignment
        $assignedStudentIds = BedAssignment::where(function ($query) {
            $query->whereNull('end_date')
                ->orWhereDate('end_date', '>=', now()->toDateString());
        })
            ->pluck('student_id');

        // Only students who currently don't have any active bed
        $students = Student::whereNotIn('id', $assignedStudentIds)
            ->orderBy('full_name')
            ->get();

        return view('beds.assign', compact('bed', 'students'));
    }

    /**
     * Assign a student to the bed.
     */
    public function storeAssignment(Request $request, Bed $bed)
    {
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

        DB::transaction(function () use ($bed, $validated) {

            // Lock bed while assigning
            $bed = Bed::where('id', $bed->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Make sure bed is still available
            if ($bed->status !== 'available' || $bed->student_id !== null) {

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
            ->with('success', 'Student assigned to bed successfully.');
    }
}
