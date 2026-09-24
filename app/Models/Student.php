<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'full_name',
        'father_name',
        'email',
        'aadhar_number',
        'mobile_number',
        'address',
        'image',
        'joining_date',
        'status',
        'hostel_id',
    ];

    protected function casts(): array
    {
        return [
            'joining_date' => 'date',
        ];
    }

    public function bedAssignments(): HasMany
    {
        return $this->hasMany(BedAssignment::class);
    }

    public function currentAssignment()
    {
        return $this->hasOne(BedAssignment::class)
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', now()->toDateString());
            });
    }

    public function fees(): HasMany
    {
        return $this->hasMany(Fee::class);
    }

    public function securityDeposits(): HasMany
    {
        return $this->hasMany(SecurityDeposit::class);
    }

    public function hostel(): BelongsTo
    {
        return $this->belongsTo(Hostel::class);
    }
    public function checkout()
{
    return $this->hasOne(Checkout::class);
}
}
