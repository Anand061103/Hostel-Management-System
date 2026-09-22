<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Bed;
use App\Models\BedAssignment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
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
     * Ensure room belongs to current hostel.
     */
    private function ensureRoomAccess(Room $room): void
    {
        $hostelId = $this->currentHostelId();

        if ((int) $room->hostel_id !== (int) $hostelId) {
            abort(403, 'You do not have access to this room.');
        }
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
     * Display rooms.
     */
    public function index(Request $request)
    {
        $hostelId = $this->currentHostelId();

        $floor = (int) $request->query('floor', 0);

        $rooms = Room::with([
            'beds.currentAssignment.student',
        ])
            ->where('hostel_id', $hostelId)
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


    /**
     * Show room creation form.
     */
    public function create(Request $request)
    {
        $this->currentHostelId();

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


    /**
     * Store a newly created room.
     */
    public function store(Request $request)
    {
        $request->validate([
            'floor' => 'required|integer|min:0|max:5',
            'bed_count' => 'required|integer|min:1|max:5',
            'room_type' => 'required|string|max:50',
        ]);

        $hostelId = $this->currentHostelId();

        $floor = (int) $request->floor;


        /*
        |--------------------------------------------------------------------------
        | Generate Room Number
        |--------------------------------------------------------------------------
        */

        $lastRoom = Room::where('hostel_id', $hostelId)
            ->where('floor', $floor)
            ->orderByDesc('id')
            ->first();

        $nextNumber = $lastRoom
            ? ((int) substr(
                $lastRoom->room_number,
                $floor === 0 ? 1 : 0
            )) + 1
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
            'hostel_id' => $hostelId,
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


    /**
     * Display the specified room.
     */
    public function show(Room $room)
    {
        $this->ensureRoomAccess($room);

        $room->load([
            'beds.currentAssignment.student',
        ]);

        $hostelId = $this->currentHostelId();

        /*
        |--------------------------------------------------------------------------
        | Only show students from current hostel
        |--------------------------------------------------------------------------
        */

        $students = Student::where('hostel_id', $hostelId)
            ->whereDoesntHave('bedAssignments', function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('end_date')
                        ->orWhereDate(
                            'end_date',
                            '>=',
                            now()->toDateString()
                        );
                });
            })
            ->orderBy('full_name')
            ->get();

        return view('rooms.show', compact(
            'room',
            'students'
        ));
    }


    /**
     * Show the form for editing the specified room.
     */
    public function edit(Room $room)
    {
        $this->ensureRoomAccess($room);

        $floors = [
            0 => 'Ground Floor',
            1 => 'First Floor',
            2 => 'Second Floor',
            3 => 'Third Floor',
            4 => 'Fourth Floor',
            5 => 'Fifth Floor',
        ];

        return view('rooms.edit', compact(
            'room',
            'floors'
        ));
    }


    /**
     * Update the specified room.
     */
    public function update(Request $request, Room $room)
    {
        $this->ensureRoomAccess($room);

        $validated = $request->validate([
            'room_type' => [
                'required',
                'string',
                'max:50',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        $room->update([
            'room_type' => $validated['room_type'],
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('rooms.show', $room)
            ->with(
                'success',
                'Room updated successfully.'
            );
    }


    /**
     * Remove the specified room.
     */
    public function destroy(Room $room)
    {
        $this->ensureRoomAccess($room);

        $room->load('beds');

        $hasOccupiedBed = $room->beds->contains(function ($bed) {
            return $bed->status === 'occupied';
        });

        if ($hasOccupiedBed) {
            return back()
                ->with(
                    'error',
                    'This room cannot be deleted because one or more beds are occupied.'
                );
        }

        $room->delete();

        return redirect()
            ->route('rooms.index', [
                'floor' => $room->floor,
            ])
            ->with(
                'success',
                'Room deleted successfully.'
            );
    }


    /**
     * Assign student to bed.
     */
    public function assignStudent(Request $request, Bed $bed)
    {
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

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
        ]);

        $bed->load('room');

        $hostelId = $this->currentHostelId();


        /*
        |--------------------------------------------------------------------------
        | Check Student Belongs To Current Hostel
        |--------------------------------------------------------------------------
        */

        $student = Student::findOrFail(
            $validated['student_id']
        );

        if ((int) $student->hostel_id !== (int) $hostelId) {
            abort(
                403,
                'You cannot assign a student from another hostel.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Check Room
        |--------------------------------------------------------------------------
        */

        if ($bed->room->status !== 'active') {

            return back()
                ->with(
                    'error',
                    'This room is inactive. Students cannot be assigned.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Check Bed
        |--------------------------------------------------------------------------
        */

        if ($bed->status !== 'available') {

            return back()
                ->with(
                    'error',
                    'This bed is not available.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Check Existing Assignment
        |--------------------------------------------------------------------------
        */

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

            return back()
                ->with(
                    'error',
                    'This student is already assigned to a bed.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Assignment
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $bed,
            $validated
        ) {

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
            ->route(
                'rooms.show',
                $bed->room_id
            )
            ->with(
                'success',
                'Student assigned successfully.'
            );
    }


    /**
     * Checkout student from bed.
     */
    public function checkoutStudent(
        Request $request,
        Bed $bed
    ) {

        $this->ensureBedAccess($bed);

        $validated = $request->validate([
            'end_date' => [
                'required',
                'date',
            ],
        ]);

        $assignment = $bed->currentAssignment;

        if (!$assignment) {

            return back()
                ->with(
                    'error',
                    'No active student assignment found for this bed.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Checkout Date
        |--------------------------------------------------------------------------
        */

        if (
            $validated['end_date']
            < $assignment->start_date->format('Y-m-d')
        ) {

            return back()
                ->with(
                    'error',
                    'Checkout date cannot be before the start date.'
                );
        }


        DB::transaction(function () use (
            $bed,
            $assignment,
            $validated
        ) {

            // Close current assignment
            $assignment->update([
                'end_date' => $validated['end_date'],
            ]);

            // Make bed available
            $bed->update([
                'status' => 'available',
            ]);
        });


        return redirect()
            ->route(
                'rooms.show',
                $bed->room_id
            )
            ->with(
                'success',
                'Student checked out successfully.'
            );
    }
}