<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'management_type',
        'plan',
        'amount',
        'duration_days',
        'status',
        'starts_at',
        'expires_at',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Check Active
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status === 'active'
            && $this->expires_at
            && now()->lt($this->expires_at);
    }
}