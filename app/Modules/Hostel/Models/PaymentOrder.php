<?php

namespace App\Modules\Hostel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentOrder extends Model
{
    protected $fillable = [
        'student_id',
        'razorpay_order_id',
        'amount',
        'status',
        'razorpay_payment_id',
        'razorpay_signature',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}