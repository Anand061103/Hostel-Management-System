<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;
class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $fees = Fee::with([
        'student',
        'payments',
    ])
    ->latest()
    ->paginate(10);

    $totalFeeAmount = Fee::sum('amount');

    $totalPaid = \App\Models\FeePayment::sum('amount');

    $totalOutstanding = max(0, $totalFeeAmount - $totalPaid);

    $pendingFees = Fee::whereIn('status', [
        'pending',
        'partial',
    ])->count();

    return view('fees.index', compact(
        'fees',
        'totalFeeAmount',
        'totalPaid',
        'totalOutstanding',
        'pendingFees'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $students = \App\Models\Student::orderBy('full_name')->get();

    return view('fees.create', compact('students'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
