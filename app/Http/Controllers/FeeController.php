<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FeeController extends Controller
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
     * Ensure fee belongs to current hostel.
     */
    private function ensureFeeAccess(Fee $fee): void
    {
        $hostelId = $this->currentHostelId();

        $fee->loadMissing('student');

        if (!$fee->student) {
            abort(404, 'Student not found for this fee.');
        }

        if ((int) $fee->student->hostel_id !== (int) $hostelId) {
            abort(403, 'You do not have access to this fee.');
        }
    }

    /**
     * Display a listing of fees.
     */
    public function index()
    {
        $hostelId = $this->currentHostelId();

        $fees = Fee::with([
            'student',
            'payments',
        ])
            ->whereHas('student', function ($query) use ($hostelId) {
                $query->where('hostel_id', $hostelId);
            })
            ->latest()
            ->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | Hostel-specific totals
        |--------------------------------------------------------------------------
        */

        $hostelFees = Fee::whereHas('student', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        });

        $totalFeeAmount = (clone $hostelFees)->sum('amount');

        $totalPaid = FeePayment::whereHas('fee.student', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        })->sum('amount');

        $totalOutstanding = max(
            0,
            $totalFeeAmount - $totalPaid
        );

        $pendingFees = (clone $hostelFees)
            ->whereIn('status', [
                'pending',
                'partial',
            ])
            ->count();

        return view('fees.index', compact(
            'fees',
            'totalFeeAmount',
            'totalPaid',
            'totalOutstanding',
            'pendingFees'
        ));
    }

    /**
     * Show fee creation form.
     */
    public function create()
    {
        $hostelId = $this->currentHostelId();

        $students = Student::where('hostel_id', $hostelId)
            ->orderBy('full_name')
            ->get();

        return view('fees.create', compact('students'));
    }

    /**
     * Record fee payment.
     */
    public function recordPayment(Request $request, Fee $fee)
    {
        $this->ensureFeeAccess($fee);

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

            $fee = Fee::where('id', $fee->id)
                ->lockForUpdate()
                ->firstOrFail();

            $fee->load('student');

            $this->ensureFeeAccess($fee);

            $paidAmount = $fee->payments()->sum('amount');

            $remainingAmount =
                (float) $fee->amount
                - (float) $paidAmount;

            if ((float) $validated['amount'] > $remainingAmount) {

                throw ValidationException::withMessages([
                    'amount' => [
                        'Payment amount cannot be greater than the remaining amount of ₹'
                        .number_format($remainingAmount, 2),
                    ],
                ]);
            }

            FeePayment::create([
                'fee_id' => $fee->id,
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'reference_no' => $validated['reference_no'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            $newPaidAmount =
                (float) $paidAmount
                + (float) $validated['amount'];

            $fee->update([
                'status' => $newPaidAmount >= (float) $fee->amount
                    ? 'paid'
                    : 'partial',
            ]);
        });

        return redirect()
            ->route('fees.index')
            ->with(
                'success',
                'Payment recorded successfully.'
            );
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified fee.
     */
    public function show(string $id)
    {
        $fee = Fee::with([
            'student',
            'payments',
        ])->findOrFail($id);

        $this->ensureFeeAccess($fee);

        return view('fees.show', compact('fee'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}