<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Bed;
use App\Models\BedAssignment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $floor = (int) $request->query('floor', 0);

       $rooms = Room::with([
    'beds.currentAssignment.student'
])
    ->where('floor', $floor)
    ->orderBy('room_number')
    ->get();

        $floors = [
            0 => 'Ground Floor',
            1 => 'First Floor',
            2 => 'Second Floor',
            3 => 'Third Floor',
            4 => 'Fourth Floor',
            5 => 'Fifth Floor',
        ];

        $currentFloorName = $floors[$floor] ?? "Floor $floor";

        return view('rooms.index', compact(
            'rooms',
            'floor',
            'floors',
            'currentFloorName'
        ));
    }


    public function create(Request $request)
    {
        $floor = (int) $request->query('floor', 0);

        $floors = [
            0 => 'Ground Floor',
            1 => 'First Floor',
            2 => 'Second Floor',
            3 => 'Third Floor',
            4 => 'Fourth Floor',
            5 => 'Fifth Floor',
        ];

        return view('rooms.create', compact('floor', 'floors'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'floor' => 'required|integer|min:0|max:5',
            'bed_count' => 'required|integer|min:1|max:5',
            'room_type' => 'required|string|max:50',
        ]);

        $floor = (int) $request->floor;

        /*
        |--------------------------------------------------------------------------
        | Generate Room Number
        |--------------------------------------------------------------------------
        */

        $lastRoom = Room::where('floor', $floor)
            ->orderByDesc('id')
            ->first();

        $nextNumber = $lastRoom
            ? ((int) substr($lastRoom->room_number, $floor === 0 ? 1 : 0)) + 1
            : 1;

        if ($floor === 0) {
            $roomNumber = 'G' . str_pad(
                $nextNumber,
                2,
                '0',
                STR_PAD_LEFT
            );
        } else {
            $roomNumber = ($floor * 100) + $nextNumber;
        }


        /*
        |--------------------------------------------------------------------------
        | Create Room
        |--------------------------------------------------------------------------
        */

        $room = Room::create([
            'room_number' => $roomNumber,
            'floor' => $floor,
            'room_type' => $request->room_type,
            'status' => 'active',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Create Beds Automatically
        |--------------------------------------------------------------------------
        */

        $bedLetters = ['A', 'B', 'C', 'D', 'E'];

        $beds = [];

        for ($i = 0; $i < $request->bed_count; $i++) {
            $beds[] = [
                'bed_number' => $bedLetters[$i],
                'status' => 'available',
            ];
        }

        $room->beds()->createMany($beds);


        return redirect()
            ->route('rooms.index', ['floor' => $floor])
            ->with(
                'success',
                "Room {$roomNumber} created successfully."
            );
    }


        public function show(Room $room)
        {
            $room->load([
                'beds.currentAssignment.student',
            ]);

            $students = Student::whereDoesntHave('bedAssignments', function ($query) {
                $query->whereNull('end_date');
            })
            ->orderBy('full_name')
            ->get();

            return view('rooms.show', compact('room', 'students'));
       }


    public function edit(Room $room)
    {
        //
    }


    public function update(Request $request, Room $room)
    {
        //
    }


    public function destroy(Room $room)
    {
        //
    }
      
       public function assignStudent(Request $request, Bed $bed)
  {
    $validated = $request->validate([
        'student_id' => ['required', 'exists:students,id'],
        'start_date' => ['required', 'date'],
        'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
    ]);

    // Bed already occupied hai
    if ($bed->status !== 'available') {
        return back()->with('error', 'This bed is not available.');
    }

    // Student already kisi active bed par assigned hai
    $alreadyAssigned = BedAssignment::where('student_id', $validated['student_id'])
        ->whereNull('end_date')
        ->exists();

    if ($alreadyAssigned) {
        return back()->with('error', 'This student is already assigned to a bed.');
    }

    DB::transaction(function () use ($bed, $validated) {

        BedAssignment::create([
            'bed_id' => $bed->id,
            'student_id' => $validated['student_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'] ?? null,
        ]);

        $bed->update([
            'status' => 'occupied',
        ]);
    });

    return redirect()
        ->route('rooms.show', $bed->room_id)
        ->with('success', 'Student assigned successfully.');
  }

public function checkoutStudent(Request $request, Bed $bed)
{
    $validated = $request->validate([
        'end_date' => ['required', 'date'],
    ]);

    $assignment = $bed->currentAssignment;

    // Bed occupied nahi hai
    if (!$assignment) {
        return back()->with('error', 'No active student assignment found for this bed.');
    }

    // Checkout date start date se pehle nahi ho sakti
    if ($validated['end_date'] < $assignment->start_date->format('Y-m-d')) {
        return back()->with('error', 'Checkout date cannot be before the start date.');
    }

    DB::transaction(function () use ($bed, $assignment, $validated) {

        // Close current assignment
        $assignment->update([
            'end_date' => $validated['end_date'],
        ]);

        // Make bed available again
        $bed->update([
            'status' => 'available',
        ]);
    });

    return redirect()
        ->route('rooms.show', $bed->room_id)
        ->with('success', 'Student checked out successfully.');
}




}