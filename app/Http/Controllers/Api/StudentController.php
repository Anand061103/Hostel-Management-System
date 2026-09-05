<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Student;
use App\Helpers\ApiResponse;

class StudentController extends Controller
{
   public function store(StoreStudentRequest $request)
{
    $student = Student::create([
        'full_name' => $request->full_name,
        'father_name' => $request->father_name,
        'email' => $request->email,
        'aadhar_number' => $request->aadhar_number,
        'mobile_number' => $request->mobile_number,
        'address' => $request->address,
        'image' => $request->image,
        'joining_date' => $request->joining_date,
        'status' => $request->status ?? 'active',
    ]);

    return ApiResponse::success(
        'Student created successfully',
        $student,
        201
    );
}
}