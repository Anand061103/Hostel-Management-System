<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index()
    {
        $students = Student::latest()->paginate(10);

        return view('students.index', compact('students'));
    }


    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('students.create');
    }


    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'father_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'unique:students,email'],
            'aadhar_number' => ['required', 'string', 'size:12', 'unique:students,aadhar_number'],
            'mobile_number' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'joining_date' => ['required', 'date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('students', 'public');
        }

        Student::create($data);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student added successfully.');
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