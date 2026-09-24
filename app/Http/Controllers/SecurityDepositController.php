<?php

namespace App\Http\Controllers;

use App\Models\SecurityDeposit;
use App\Models\SecurityPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SecurityDepositController extends Controller
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
     * Ensure security deposit belongs to current hostel.
     */
    private function ensureSecurityAccess(
        SecurityDeposit $securityDeposit
    ): void {
        $hostelId = $this->currentHostelId();

        $securityDeposit->loadMissing('student');

        if (!$securityDeposit->student) {
            abort(
                404,
                'Student not found for this security deposit.'
            );
        }

        if (
            (int) $securityDeposit->student->hostel_id
            !== (int) $hostelId
        ) {
            abort(
                403,
                'You do not have access to this security deposit.'
            );
        }
    }

    /**
     * Display a listing of security deposits.
     */
    public function index()
    {
        $hostelId = $this->currentHostelId();

        $securityDeposits = SecurityDeposit::with([
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

        $hostelDeposits = SecurityDeposit::whereHas(
            'student',
            function ($query) use ($hostelId) {
                $query->where('hostel_id', $hostelId);
            }
        );

        $totalRequired = (clone $hostelDeposits)
            ->sum('required_amount');

        $totalPaid = (clone $hostelDeposits)
            ->sum('paid_amount');

        $totalOutstanding = max(
            0,
            $totalRequired - $totalPaid
        );

        $pendingDeposits = (clone $hostelDeposits)
            ->where('status', 'pending')
            ->count();


        return view(
            'security_deposits.index',
            compact(
                'securityDeposits',
                'totalRequired',
                'totalPaid',
                'totalOutstanding',
                'pendingDeposits'
            )
        );
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display specified security deposit.
     */
    public function show(SecurityDeposit $securityDeposit)
    {
        $this->ensureSecurityAccess($securityDeposit);

        $securityDeposit->load([
            'student',
            'payments' => function ($query) {
                $query->latest('payment_date')
                    ->latest('id');
            },
            'settlements' => function ($query) {
                $query->latest('settlement_date')
                    ->latest('id');
            },
        ]);

        return view(
            'security_deposits.show',
            compact('securityDeposit')
        );
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

    /**
     * Record security payment.
     */
    public function recordPayment(
        Request $request,
        SecurityDeposit $securityDeposit
    ) {
        $this->ensureSecurityAccess($securityDeposit);

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

        DB::transaction(function () use (
            $securityDeposit,
            $validated
        ) {

            $securityDeposit = SecurityDeposit::where(
                'id',
                $securityDeposit->id
            )
                ->lockForUpdate()
                ->firstOrFail();

            $this->ensureSecurityAccess($securityDeposit);

            $paidAmount =
                (float) $securityDeposit->paid_amount;

            $remainingAmount =
                (float) $securityDeposit->required_amount
                - $paidAmount;

            if (
                (float) $validated['amount']
                > $remainingAmount
            ) {

                throw ValidationException::withMessages([
                    'amount' => [
                        'Payment amount cannot be greater than the remaining security amount of ₹'
                        .number_format($remainingAmount, 2),
                    ],
                ]);
            }

            SecurityPayment::create([
                'security_deposit_id' => $securityDeposit->id,
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'reference_no' =>
                    $validated['reference_no'] ?? null,
                'notes' =>
                    $validated['notes'] ?? null,
            ]);

            $newPaidAmount =
                $paidAmount
                + (float) $validated['amount'];

            $securityDeposit->update([
                'paid_amount' => $newPaidAmount,

                'status' => $newPaidAmount >=
                    (float) $securityDeposit->required_amount
                        ? 'held'
                        : 'pending',

                'received_date' =>
                    $validated['payment_date'],
            ]);
        });

        return redirect()
            ->route('security-deposits.index')
            ->with(
                'success',
                'Security payment recorded successfully.'
            );
    }
}