<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecuritySettlement extends Model
{
    protected $fillable = [
        'security_deposit_id',
        'deduction_amount',
        'refund_amount',
        'settlement_date',
        'reason',
        'status',
    ];

    protected $casts = [
        'deduction_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'settlement_date' => 'date',
    ];

    public function securityDeposit(): BelongsTo
    {
        return $this->belongsTo(SecurityDeposit::class);
    }
}