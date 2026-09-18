<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityPayment extends Model
{
    protected $fillable = [
        'security_deposit_id',
        'amount',
        'payment_date',
        'payment_method',
        'reference_no',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function securityDeposit(): BelongsTo
    {
        return $this->belongsTo(SecurityDeposit::class);
    }
}