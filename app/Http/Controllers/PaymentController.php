<?php

namespace App\Http\Controllers;

use App\Models\PaymentOrder;
use App\Models\Student;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
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

        // Calculate current outstanding amount
        $outstanding = $student->fees()
            ->with('payments')
            ->get()
            ->sum(function ($fee) {
                return max(
                    0,
                    (float) $fee->amount - (float) $fee->payments->sum('amount')
                );
            });

        // Prevent overpayment
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
}