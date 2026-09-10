<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Bed;
use App\Models\BedAssignment;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\SecurityDeposit;
use Illuminate\Support\Facades\DB;
class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
   public function index()
{
    $students = Student::with([
        'currentAssignment.bed.room'
    ])
    ->latest()
    ->paginate(10);

    return view('students.index', compact('students'));
}

    /**
     * Show the form for creating a new student.
     */
   public function create()
{
    $floors = [
        0 => 'Ground Floor',
        1 => 'First Floor',
        2 => 'Second Floor',
        3 => 'Third Floor',
        4 => 'Fourth Floor',
        5 => 'Fifth Floor',
    ];

    $rooms = \App\Models\Room::with([
        'beds' => function ($query) {
            $query->where('status', 'available');
        }
    ])
    ->where('status', 'active')
    ->orderBy('room_number')
    ->get();

    return view('students.create', compact('floors', 'rooms'));
}

    /**
     * Store a newly created student.
     */
   public function store(Request $request)
{
    $data = $request->validate([

        // Student
        'full_name' => ['required', 'string', 'max:255'],
        'father_name' => ['required', 'string', 'max:255'],

        'email' => [
            'nullable',
            'email',
            'unique:students,email',
        ],

        'aadhar_number' => [
            'required',
            'string',
            'size:12',
            'unique:students,aadhar_number',
        ],

        'mobile_number' => ['required', 'string', 'max:15'],
        'address' => ['required', 'string'],

        'image' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],

        'joining_date' => ['required', 'date'],
        'status' => ['required', 'in:active,inactive'],


        // Monthly Fee
        'monthly_fee' => [
            'required',
            'numeric',
            'gt:0',
        ],

        'initial_payment' => [
            'nullable',
            'numeric',
            'min:0',
            'lte:monthly_fee',
        ],

        'payment_date' => [
            'nullable',
            'date',
        ],

        'payment_method' => [
            'nullable',
            'in:cash,upi,bank_transfer,card,other',
        ],
            'fee_due_date' => [
                'required',
                'date',
            ],

        // Security Deposit
        'security_required' => [
            'required',
            'numeric',
            'min:0',
        ],

        'security_paid' => [
            'nullable',
            'numeric',
            'min:0',
            'lte:security_required',
        ],

        'security_received_date' => [
            'nullable',
            'date',
        ],


        // Room / Bed
        'floor' => [
            'required',
            'integer',
            'min:0',
            'max:5',
        ],

        'room_id' => [
            'required',
            'exists:rooms,id',
        ],

        'bed_id' => [
            'required',
            'exists:beds,id',
        ],
    ]);


    /*
    |--------------------------------------------------------------------------
    | Check Room & Bed
    |--------------------------------------------------------------------------
    */

    $bed = Bed::with('room')->findOrFail($data['bed_id']);

    if (!$bed->room) {
        return back()
            ->withInput()
            ->with('error', 'The selected bed does not belong to a valid room.');
    }

    if ((int) $bed->room_id !== (int) $data['room_id']) {
        return back()
            ->withInput()
            ->with('error', 'The selected bed does not belong to the selected room.');
    }

    if ((int) $bed->room->floor !== (int) $data['floor']) {
        return back()
            ->withInput()
            ->with('error', 'The selected room does not belong to the selected floor.');
    }

    if ($bed->room->status !== 'active') {
        return back()
            ->withInput()
            ->with('error', 'This room is inactive and cannot be assigned.');
    }

    if ($bed->status !== 'available') {
        return back()
            ->withInput()
            ->with('error', 'This bed is no longer available.');
    }


    /*
    |--------------------------------------------------------------------------
    | Create Everything Together
    |--------------------------------------------------------------------------
    */

    DB::transaction(function () use ($request, $data, $bed) {

        // Upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('students', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | 1. Create Student
        |--------------------------------------------------------------------------
        */

        $student = Student::create([
            'full_name' => $data['full_name'],
            'father_name' => $data['father_name'],
            'email' => $data['email'] ?? null,
            'aadhar_number' => $data['aadhar_number'],
            'mobile_number' => $data['mobile_number'],
            'address' => $data['address'],
            'image' => $data['image'] ?? null,
            'joining_date' => $data['joining_date'],
            'status' => $data['status'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | 2. Create Monthly Fee
        |--------------------------------------------------------------------------
        */

        $monthlyFee = Fee::create([
            'student_id' => $student->id,
            'fee_type' => 'Monthly Fee',
            'description' => 'Monthly hostel fee',
            'amount' => $data['monthly_fee'],
            'period_start' => $data['joining_date'],
            'period_end' => \Carbon\Carbon::parse($data['joining_date'])
                ->addMonth()
                ->subDay(),
           'due_date' => $data['fee_due_date'],
            'status' => 'pending',
        ]);


        /*
        |--------------------------------------------------------------------------
        | 3. Initial Fee Payment
        |--------------------------------------------------------------------------
        */

        $initialPayment = $data['initial_payment'] ?? 0;

        if ($initialPayment > 0) {

            FeePayment::create([
                'fee_id' => $monthlyFee->id,
                'amount' => $initialPayment,
                'payment_date' => $data['payment_date'] ?? $data['joining_date'],
                'payment_method' => $data['payment_method'] ?? 'cash',
            ]);

            $monthlyFee->update([
                'status' => $initialPayment >= $monthlyFee->amount
                    ? 'paid'
                    : 'partial',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 4. Security Deposit
        |--------------------------------------------------------------------------
        */

        $securityRequired = $data['security_required'];
        $securityPaid = $data['security_paid'] ?? 0;

        $securityStatus = 'pending';

        if ($securityPaid >= $securityRequired) {
            $securityStatus = 'held';
        }

        SecurityDeposit::create([
            'student_id' => $student->id,
            'required_amount' => $securityRequired,
            'paid_amount' => $securityPaid,
            'status' => $securityStatus,
            'received_date' => $securityPaid > 0
                ? ($data['security_received_date'] ?? $data['joining_date'])
                : null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | 5. Bed Assignment
        |--------------------------------------------------------------------------
        */

        BedAssignment::create([
            'bed_id' => $bed->id,
            'student_id' => $student->id,
            'start_date' => $data['joining_date'],
            'end_date' => null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | 6. Mark Bed Occupied
        |--------------------------------------------------------------------------
        */

        $bed->update([
            'status' => 'occupied',
        ]);
    });


    return redirect()
        ->route('students.index')
        ->with('success', 'Student admitted successfully with fee, security deposit and bed assignment.');
}


    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }


    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }


    /**
     * Update the specified student.
     */
    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'father_name' => ['required', 'string', 'max:255'],

            'email' => [
                'nullable',
                'email',
                'unique:students,email,' . $student->id,
            ],

            'aadhar_number' => [
                'required',
                'string',
                'size:12',
                'unique:students,aadhar_number,' . $student->id,
            ],

            'mobile_number' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string'],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'joining_date' => ['required', 'date'],
            'status' => ['required', 'in:active,inactive'],
        ]);


        // New image upload
        if ($request->hasFile('image')) {

            // Delete old image
            if ($student->image) {
                Storage::disk('public')->delete($student->image);
            }

            // Store new image
            $data['image'] = $request->file('image')
                ->store('students', 'public');
        }


        $student->update($data);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully.');
    }


    /**
     * Remove the specified student.
     */
    public function destroy(Student $student)
    {
        // Delete student image
        if ($student->image) {
            Storage::disk('public')->delete($student->image);
        }

        // Delete student
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

   public function bulkDestroy(Request $request)
{
    $studentIds = $request->input('student_ids', []);

    if (empty($studentIds)) {
        return redirect()
            ->route('students.index')
            ->with('error', 'Please select at least one student.');
    }

    $students = Student::whereIn('id', $studentIds)->get();

    foreach ($students as $student) {

        // Delete image
        if ($student->image) {
            Storage::disk('public')->delete($student->image);
        }

        // Delete student
        $student->delete();
    }

    return redirect()
        ->route('students.index')
        ->with('success', count($studentIds) . ' students deleted successfully.');
}




}