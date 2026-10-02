<?php

namespace App\Modules\Hostel\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Hostel\Models\Fee;
use App\Modules\Hostel\Models\FeePayment;
use App\Modules\Hostel\Models\PaymentOrder;
use App\Modules\Hostel\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    /**
     * Create Razorpay order.
     */
    public function createOrder(Request $request, Student $student)
    {
        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'gt:0',
            ],
        ]);

        $amount = (float) $validated['amount'];

        $outstanding = $student->fees()
            ->with('payments')
            ->get()
            ->sum(function ($fee) {
                return max(
                    0,
                    (float) $fee->amount -
                    (float) $fee->payments->sum('amount')
                );
            });

        if ($amount > $outstanding) {
            return response()->json([
                'success' => false,
                'message' => 'Payment cannot be greater than the outstanding amount.'
            ], 422);
        }

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $order = $api->order->create([
            'receipt' => 'student_' . $student->id . '_' . time(),
            'amount' => (int) round($amount * 100),
            'currency' => 'INR',
        ]);

        PaymentOrder::create([
            'student_id' => $student->id,
            'razorpay_order_id' => $order['id'],
            'amount' => $amount,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'order_id' => $order['id'],
            'amount' => $amount,
            'key' => config('services.razorpay.key'),
        ]);
    }

    /**
     * Verify Razorpay payment and record hostel fee payment.
     */
    public function verifyPayment(Request $request, Student $student)
    {
        $validated = $request->validate([
            'razorpay_payment_id' => ['required', 'string'],
            'razorpay_order_id' => ['required', 'string'],
            'razorpay_signature' => ['required', 'string'],
        ]);

        $paymentOrder = PaymentOrder::where(
            'razorpay_order_id',
            $validated['razorpay_order_id']
        )
            ->where('student_id', $student->id)
            ->lockForUpdate()
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Payment Processing
        |--------------------------------------------------------------------------
        */

        if ($paymentOrder->status === 'paid') {
            return response()->json([
                'success' => true,
                'message' => 'Payment already processed.'
            ]);
        }

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        /*
        |--------------------------------------------------------------------------
        | Verify Razorpay Signature
        |--------------------------------------------------------------------------
        */

        try {

            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $paymentOrder->razorpay_order_id,
                'razorpay_payment_id' => $validated['razorpay_payment_id'],
                'razorpay_signature' => $validated['razorpay_signature'],
            ]);

        } catch (\Exception $e) {

            $paymentOrder->update([
                'status' => 'failed',
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Fetch Razorpay Payment
        |--------------------------------------------------------------------------
        */

        $payment = $api->payment->fetch(
            $validated['razorpay_payment_id']
        );

        /*
        |--------------------------------------------------------------------------
        | Verify Order
        |--------------------------------------------------------------------------
        */

        if ($payment['order_id'] !== $paymentOrder->razorpay_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Payment order mismatch.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Verify Amount
        |--------------------------------------------------------------------------
        */

        $paidAmount = ((int) $payment['amount']) / 100;

        if (
            abs($paidAmount - (float) $paymentOrder->amount) > 0.01
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Payment amount mismatch.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Verify Captured Status
        |--------------------------------------------------------------------------
        */

        if ($payment['status'] !== 'captured') {
            return response()->json([
                'success' => false,
                'message' => 'Payment has not been captured yet.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Record Fee Payment
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $student,
            $paymentOrder,
            $validated,
            $paidAmount
        ) {

            $student = Student::whereKey($student->id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Current Outstanding
            |--------------------------------------------------------------------------
            */

            $outstanding = $student->fees()
                ->with('payments')
                ->get()
                ->sum(function ($fee) {
                    return max(
                        0,
                        (float) $fee->amount -
                        (float) $fee->payments->sum('amount')
                    );
                });

            if ($paidAmount > $outstanding + 0.01) {
                abort(
                    422,
                    'Payment is greater than the current outstanding amount.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Generate Missing Monthly Fee Records
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

            $joiningDate = Carbon::parse($student->joining_date);
            $today = Carbon::today();

            $totalMonths = $joiningDate->diffInMonths($today) + 1;

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
            | Allocate Payment — Oldest Fee First
            |--------------------------------------------------------------------------
            */

            $remainingPayment = $paidAmount;

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
                | Create Actual Fee Payment
                |--------------------------------------------------------------------------
                */

                FeePayment::create([
                    'fee_id' => $fee->id,
                    'amount' => $allocatedAmount,
                    'payment_date' => now()->toDateString(),
                    'payment_method' => 'upi',
                    'reference_no' => $validated['razorpay_payment_id'],
                    'notes' => 'Razorpay online payment',
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

            /*
            |--------------------------------------------------------------------------
            | Mark Razorpay Order Paid
            |--------------------------------------------------------------------------
            */

            $paymentOrder->update([
                'status' => 'paid',
                'razorpay_payment_id' => $validated['razorpay_payment_id'],
                'razorpay_signature' => $validated['razorpay_signature'],
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Payment verified and fee recorded successfully.'
        ]);
    }
}