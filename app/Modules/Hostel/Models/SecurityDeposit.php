<?php

namespace App\Modules\Hostel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SecurityDeposit extends Model
{
    protected $fillable = [
        'student_id',
        'required_amount',
        'paid_amount',
        'status',
        'received_date',
    ];

    protected $casts = [
        'required_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'received_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function getRemainingAmountAttribute()
    {
        return max(
            0,
            $this->required_amount - $this->paid_amount
        );
    }

    public function settlements(): HasMany
    {
        return $this->hasMany(SecuritySettlement::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SecurityPayment::class);
    }
}