<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkout extends Model
{
    protected $fillable = [
        'student_id',
        'room_id',
        'bed_id',
        'checkout_date',
        'reason',
        'notes',
        'fee_outstanding',
        'security_deposit_amount',
        'security_deduction',
        'security_refund',
        'refund_method',
        'refund_reference',
        'created_by',
    ];

    protected $casts = [
        'checkout_date' => 'date',
        'fee_outstanding' => 'decimal:2',
        'security_deposit_amount' => 'decimal:2',
        'security_deduction' => 'decimal:2',
        'security_refund' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function bed(): BelongsTo
    {
        return $this->belongsTo(Bed::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}