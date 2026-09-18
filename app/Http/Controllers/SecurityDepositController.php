<?php

namespace App\Http\Controllers;

use App\Models\SecurityDeposit;
use App\Models\SecurityPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SecurityDepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $securityDeposits = SecurityDeposit::with([
            'student',
            'payments',
        ])
            ->latest()
            ->paginate(10);

        $totalRequired = SecurityDeposit::sum('required_amount');

        $totalPaid = SecurityDeposit::sum('paid_amount');

        $totalOutstanding = max(
            0,
            $totalRequired - $totalPaid
        );

        $pendingDeposits = SecurityDeposit::where(
            'status',
            'pending'
        )->count();

        return view('security_deposits.index', compact(
            'securityDeposits',
            'totalRequired',
            'totalPaid',
            'totalOutstanding',
            'pendingDeposits'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(SecurityDeposit $securityDeposit)
    {
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

    public function recordPayment(Request $request, SecurityDeposit $securityDeposit)
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

        DB::transaction(function () use ($securityDeposit, $validated) {

            // Lock security deposit while processing payment
            $securityDeposit = SecurityDeposit::where(
                'id',
                $securityDeposit->id
            )
                ->lockForUpdate()
                ->firstOrFail();

            // Current paid amount
            $paidAmount = (float) $securityDeposit->paid_amount;

            // Remaining amount
            $remainingAmount =
                (float) $securityDeposit->required_amount
                - $paidAmount;

            // Prevent overpayment
            if ((float) $validated['amount'] > $remainingAmount) {

                throw ValidationException::withMessages([
                    'amount' => [
                        'Payment amount cannot be greater than the remaining security amount of ₹'
                        .number_format($remainingAmount, 2),
                    ],
                ]);
            }

            // Create payment history
            SecurityPayment::create([
                'security_deposit_id' => $securityDeposit->id,
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'reference_no' => $validated['reference_no'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // New paid amount
            $newPaidAmount =
                $paidAmount + (float) $validated['amount'];

            // Update security deposit
            $securityDeposit->update([
                'paid_amount' => $newPaidAmount,

                'status' => $newPaidAmount >=
                    (float) $securityDeposit->required_amount
                        ? 'held'
                        : 'pending',

                'received_date' => $validated['payment_date'],
            ]);
        });

        return redirect()
            ->route('security-deposits.index')
            ->with('success', 'Security payment recorded successfully.');
    }
}
