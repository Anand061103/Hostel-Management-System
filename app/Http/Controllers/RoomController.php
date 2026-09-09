<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $floor = (int) $request->query('floor', 0);

        $rooms = Room::with('beds')
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
        //
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
}