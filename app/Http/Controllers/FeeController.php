<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\FeePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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



public function recordPayment(Request $request, Fee $fee)
{
    $validated = $request->validate([
        'amount' => [
            'required',
            'numeric',
            'gt:0',
        ],

        'payment_date' => [
            'required',
            'date',
        ],

        'payment_method' => [
            'required',
            'in:cash,upi,bank_transfer,card,other',
        ],

        'reference_no' => [
            'nullable',
            'string',
            'max:100',
        ],

        'notes' => [
            'nullable',
            'string',
            'max:1000',
        ],
    ]);


    DB::transaction(function () use ($fee, $validated) {

        // Lock this fee while processing the payment
        $fee = Fee::where('id', $fee->id)
            ->lockForUpdate()
            ->firstOrFail();


        // Calculate already paid amount
        $paidAmount = $fee->payments()->sum('amount');

        // Calculate remaining amount
        $remainingAmount = (float) $fee->amount - (float) $paidAmount;


        // Prevent overpayment
        if ((float) $validated['amount'] > $remainingAmount) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'amount' => [
                    'Payment amount cannot be greater than the remaining amount of ₹'
                    . number_format($remainingAmount, 2),
                ],
            ]);
        }


        // Create payment record
        FeePayment::create([
            'fee_id' => $fee->id,
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'payment_method' => $validated['payment_method'],
            'reference_no' => $validated['reference_no'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);


        // Calculate new paid amount
        $newPaidAmount = (float) $paidAmount + (float) $validated['amount'];


        // Update fee status
        if ($newPaidAmount >= (float) $fee->amount) {

            $fee->update([
                'status' => 'paid',
            ]);

        } else {

            $fee->update([
                'status' => 'partial',
            ]);
        }
    });


    return redirect()
        ->route('fees.index')
        ->with('success', 'Payment recorded successfully.');
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
