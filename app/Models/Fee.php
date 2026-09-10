<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Student;
use App\Models\FeePayment;
class Fee extends Model
{
    protected $fillable = [
        'student_id',
        'fee_type',
        'description',
        'amount',
        'period_start',
        'period_end',
        'due_date',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'period_start' => 'date',
        'period_end' => 'date',
        'due_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(FeePayment::class);
    }


            public function getPaidAmountAttribute()
        {
            return $this->payments->sum('amount');
        }

        public function getRemainingAmountAttribute()
        {
            return max(0, $this->amount - $this->paid_amount);
        }
}