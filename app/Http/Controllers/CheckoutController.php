<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Student;
use App\Models\Fee;
use App\Models\SecurityDeposit;
use App\Models\SecuritySettlement;
use App\Models\BedAssignment;
use App\Models\FeePayment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
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
     * Ensure student belongs to current hostel.
     */
    private function ensureStudentAccess(Student $student): void
    {
        $hostelId = $this->currentHostelId();

        if ((int) $student->hostel_id !== (int) $hostelId) {
            abort(403, 'You do not have access to this student.');
        }
    }

    /**
     * Calculate fee summary according to joining date
     * and selected checkout date.
     */
    private function calculateFeeSummary(
        Student $student,
        string $checkoutDate
    ): array {
        $joiningDate = Carbon::parse($student->joining_date);
        $checkoutDate = Carbon::parse($checkoutDate);

        if ($checkoutDate->lt($joiningDate)) {
            abort(
                422,
                'Checkout date cannot be before the joining date.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Billing Months
        |--------------------------------------------------------------------------
        |
        | Example:
        | 1 Jan -> 1 May = 5 months
        |
        */

        $totalMonths = $joiningDate->diffInMonths($checkoutDate) + 1;

        /*
        |--------------------------------------------------------------------------
        | Monthly Fee
        |--------------------------------------------------------------------------
        */

        $monthlyFeeRecord = Fee::where('student_id', $student->id)
            ->where('fee_type', 'Monthly Fee')
            ->orderBy('id')
            ->first();

        $monthlyFee = $monthlyFeeRecord
            ? (float) $monthlyFeeRecord->amount
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Required Fee
        |--------------------------------------------------------------------------
        */

        $requiredFee = $monthlyFee * $totalMonths;

        /*
        |--------------------------------------------------------------------------
        | Actual Paid Fee
        |--------------------------------------------------------------------------
        */

        $totalPaid = FeePayment::whereHas('fee', function ($query) use ($student) {
            $query->where('student_id', $student->id);
        })->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Outstanding
        |--------------------------------------------------------------------------
        */

        $outstanding = max(
            0,
            $requiredFee - (float) $totalPaid
        );

        return [
            'totalMonths' => $totalMonths,
            'monthlyFee' => $monthlyFee,
            'requiredFee' => $requiredFee,
            'totalPaid' => (float) $totalPaid,
            'outstanding' => $outstanding,
        ];
    }

    /**
     * Show checkout page.
     */
    public function create(Student $student)
    {
        $this->ensureStudentAccess($student);

        if ($student->status === 'checked_out') {
            abort(403, 'This student has already been checked out.');
        }

        /*
        |--------------------------------------------------------------------------
        | Current Bed Assignment
        |--------------------------------------------------------------------------
        */

        $assignment = BedAssignment::with([
            'bed.room'
        ])
            ->where('student_id', $student->id)
            ->whereNull('end_date')
            ->latest('id')
            ->first();

        if (!$assignment || !$assignment->bed || !$assignment->bed->room) {
            abort(
                403,
                'This student does not have an active room/bed assignment.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Fee Summary
        |--------------------------------------------------------------------------
        */

        $feeSummary = $this->calculateFeeSummary(
            $student,
            now()->toDateString()
        );

        $totalMonths = $feeSummary['totalMonths'];
        $monthlyFee = $feeSummary['monthlyFee'];
        $totalFees = $feeSummary['requiredFee'];
        $totalPaidFees = $feeSummary['totalPaid'];
        $feeOutstanding = $feeSummary['outstanding'];

        /*
        |--------------------------------------------------------------------------
        | Security Deposit
        |--------------------------------------------------------------------------
        */

        $securityDeposit = SecurityDeposit::where('student_id', $student->id)
            ->latest('id')
            ->first();

        $securityRequired = $securityDeposit
            ? (float) $securityDeposit->required_amount
            : 0;

        $securityPaid = $securityDeposit
            ? (float) $securityDeposit->paid_amount
            : 0;

        $securityRemaining = max(
            0,
            $securityRequired - $securityPaid
        );

        /*
        |--------------------------------------------------------------------------
        | Checkout Availability
        |--------------------------------------------------------------------------
        |
        | Security deposit does NOT have to be fully paid.
        | Only outstanding fees block checkout.
        |
        */

        $canCheckout = $feeOutstanding <= 10;

        return view('checkouts.create', compact(
            'student',
            'assignment',

            // Fee data
            'totalMonths',
            'monthlyFee',
            'totalFees',
            'totalPaidFees',
            'feeOutstanding',

            // Security data
            'securityDeposit',
            'securityRequired',
            'securityPaid',
            'securityRemaining',

            'canCheckout'
        ));
    }

    /**
     * Complete checkout.
     */
    public function store(Request $request, Student $student)
    {
        $this->ensureStudentAccess($student);

        if ($student->status === 'checked_out') {
            abort(403, 'This student has already been checked out.');
        }

        $validated = $request->validate([
            'checkout_date' => ['required', 'date'],
            'reason' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],

            'security_deduction' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'security_settlement_reason' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'refund_method' => [
                'nullable',
                'string',
                'max:50',
            ],

            'refund_reference' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        DB::transaction(function () use ($student, $validated) {

            /*
            |--------------------------------------------------------------------------
            | Lock Student
            |--------------------------------------------------------------------------
            */

            $student = Student::whereKey($student->id)
                ->lockForUpdate()
                ->firstOrFail();

            $this->ensureStudentAccess($student);

            if ($student->status === 'checked_out') {
                abort(403, 'This student has already been checked out.');
            }

            /*
            |--------------------------------------------------------------------------
            | Active Bed Assignment
            |--------------------------------------------------------------------------
            */

            $assignment = BedAssignment::with([
                'bed.room'
            ])
                ->where('student_id', $student->id)
                ->whereNull('end_date')
                ->lockForUpdate()
                ->first();

            if (!$assignment || !$assignment->bed || !$assignment->bed->room) {
                abort(
                    403,
                    'This student does not have an active room/bed assignment.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Fee Clearance
            |--------------------------------------------------------------------------
            */

            $feeSummary = $this->calculateFeeSummary(
                $student,
                $validated['checkout_date']
            );

            $totalFees = $feeSummary['requiredFee'];
            $totalPaidFees = $feeSummary['totalPaid'];
            $feeOutstanding = $feeSummary['outstanding'];

            /*
            |--------------------------------------------------------------------------
            | Outstanding Fee Blocks Checkout
            |--------------------------------------------------------------------------
            */

            if ($feeOutstanding > 10) {
                abort(
                    422,
                    'Checkout cannot be completed because the student has outstanding fees of ₹' .
                    number_format($feeOutstanding, 2)
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Security Deposit
            |--------------------------------------------------------------------------
            */

            $securityDeposit = SecurityDeposit::where('student_id', $student->id)
                ->lockForUpdate()
                ->latest('id')
                ->first();

            $securityPaid = $securityDeposit
                ? (float) $securityDeposit->paid_amount
                : 0;

            /*
            |--------------------------------------------------------------------------
            | Security Deduction
            |--------------------------------------------------------------------------
            */

            $deduction = (float) ($validated['security_deduction'] ?? 0);

            /*
            | Deduction cannot exceed ACTUALLY PAID security.
            */

            if ($deduction > $securityPaid) {
                abort(
                    422,
                    'Security deduction cannot be greater than the paid security deposit.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Refund
            |--------------------------------------------------------------------------
            */

            $refund = max(
                0,
                $securityPaid - $deduction
            );

            /*
            |--------------------------------------------------------------------------
            | Create Security Settlement
            |--------------------------------------------------------------------------
            */

            if ($securityDeposit) {

                SecuritySettlement::create([
                    'security_deposit_id' => $securityDeposit->id,
                    'deduction_amount' => $deduction,
                    'refund_amount' => $refund,
                    'settlement_date' => $validated['checkout_date'],
                    'reason' => $validated['security_settlement_reason'] ?? null,
                    'status' => 'completed',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Create Checkout Record
            |--------------------------------------------------------------------------
            */

            Checkout::create([
                'student_id' => $student->id,
                'room_id' => $assignment->bed->room->id,
                'bed_id' => $assignment->bed->id,

                'checkout_date' => $validated['checkout_date'],
                'reason' => $validated['reason'] ?? null,
                'notes' => $validated['notes'] ?? null,

                // Fee must already be fully cleared.
                'fee_outstanding' => 0,

                'security_deposit_amount' => $securityPaid,
                'security_deduction' => $deduction,
                'security_refund' => $refund,

                'refund_method' => $refund > 0
                    ? ($validated['refund_method'] ?? null)
                    : null,

                'refund_reference' => $refund > 0
                    ? ($validated['refund_reference'] ?? null)
                    : null,

                'created_by' => Auth::id(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Close Bed Assignment
            |--------------------------------------------------------------------------
            */

            $assignment->update([
                'end_date' => $validated['checkout_date'],
            ]);

            /*
            |--------------------------------------------------------------------------
            | Release Bed
            |--------------------------------------------------------------------------
            */

            $assignment->bed->update([
                'status' => 'available',
                'student_id' => null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Mark Student as Checked Out
            |--------------------------------------------------------------------------
            */

            $student->update([
                'status' => 'checked_out',
            ]);
        });

        return redirect()
            ->route('students.index')
            ->with(
                'success',
                'Student checkout completed successfully.'
            );
    }
      
    /**
 * Pay outstanding monthly fees during checkout.
 */
public function payFees(Request $request, Student $student)
{
    $this->ensureStudentAccess($student);

    if ($student->status === 'checked_out') {
        abort(403, 'This student has already been checked out.');
    }

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
            'max:255',
        ],

        'notes' => [
            'nullable',
            'string',
        ],
    ]);

    DB::transaction(function () use ($student, $validated) {

        /*
        |--------------------------------------------------------------------------
        | Lock Student
        |--------------------------------------------------------------------------
        */

        $student = Student::whereKey($student->id)
            ->lockForUpdate()
            ->firstOrFail();

        $this->ensureStudentAccess($student);

        if ($student->status === 'checked_out') {
            abort(403, 'This student has already been checked out.');
        }

        /*
        |--------------------------------------------------------------------------
        | Calculate Required Fee
        |--------------------------------------------------------------------------
        */

        $feeSummary = $this->calculateFeeSummary(
            $student,
            now()->toDateString()
        );

        $outstanding = (float) $feeSummary['outstanding'];

        if ($outstanding <= 10) {
            abort(422, 'There is no outstanding fee for this student.');
        }

        $paymentAmount = (float) $validated['amount'];

        /*
        |--------------------------------------------------------------------------
        | Prevent Overpayment
        |--------------------------------------------------------------------------
        */

        if ($paymentAmount > $outstanding) {
            abort(
                422,
                'Payment cannot be greater than the outstanding fee of ₹' .
                number_format($outstanding, 2)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Get Monthly Fee
        |--------------------------------------------------------------------------
        */

        $monthlyFeeRecord = Fee::where('student_id', $student->id)
            ->where('fee_type', 'Monthly Fee')
            ->orderBy('period_start')
            ->first();

        if (!$monthlyFeeRecord) {
            abort(422, 'Monthly fee record was not found.');
        }

        $monthlyFee = (float) $monthlyFeeRecord->amount;

        /*
        |--------------------------------------------------------------------------
        | Generate Missing Monthly Fee Records
        |--------------------------------------------------------------------------
        |
        | Our admission process initially creates only the first month.
        | Here we create the remaining monthly fee records as required.
        |
        */

        $joiningDate = Carbon::parse($student->joining_date);

        $totalMonths = $feeSummary['totalMonths'];

        for ($i = 0; $i < $totalMonths; $i++) {

            $periodStart = $joiningDate->copy()->addMonths($i);

            $periodEnd = $periodStart->copy()
                ->addMonth()
                ->subDay();

            Fee::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'fee_type' => 'Monthly Fee',
                    'period_start' => $periodStart->toDateString(),
                ],
                [
                    'description' => 'Monthly hostel fee',
                    'amount' => $monthlyFee,
                    'period_end' => $periodEnd->toDateString(),
                    'due_date' => $periodStart->toDateString(),
                    'status' => 'pending',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Allocate Payment
        |--------------------------------------------------------------------------
        |
        | Payment is allocated from oldest unpaid month first.
        |
        */

        $remainingPayment = $paymentAmount;

        $fees = Fee::with('payments')
            ->where('student_id', $student->id)
            ->where('fee_type', 'Monthly Fee')
            ->orderBy('period_start')
            ->lockForUpdate()
            ->get();

        foreach ($fees as $fee) {

            if ($remainingPayment <= 0) {
                break;
            }

            $alreadyPaid = (float) $fee->payments->sum('amount');

            $feeRemaining = max(
                0,
                (float) $fee->amount - $alreadyPaid
            );

            if ($feeRemaining <= 0) {
                $fee->update([
                    'status' => 'paid',
                ]);

                continue;
            }

            $allocatedAmount = min(
                $remainingPayment,
                $feeRemaining
            );

            /*
            |--------------------------------------------------------------------------
            | Create Payment
            |--------------------------------------------------------------------------
            */

            FeePayment::create([
                'fee_id' => $fee->id,
                'amount' => $allocatedAmount,
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'reference_no' => $validated['reference_no'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Update Fee Status
            |--------------------------------------------------------------------------
            */

            $newPaidAmount = $alreadyPaid + $allocatedAmount;

            $fee->update([
                'status' => $newPaidAmount >= (float) $fee->amount
                    ? 'paid'
                    : 'partial',
            ]);

            $remainingPayment -= $allocatedAmount;
        }

        /*
        |--------------------------------------------------------------------------
        | Safety Check
        |--------------------------------------------------------------------------
        */

        if ($remainingPayment > 0.01) {
            abort(
                422,
                'Unable to allocate the complete payment amount.'
            );
        }
    });

    return redirect()
        ->route('students.checkout.create', $student)
        ->with(
            'success',
            'Fee payment of ₹' .
            number_format((float) $validated['amount'], 2) .
            ' recorded successfully.'
        );
}





}