<?php

namespace App\Models;
use App\Models\BedAssignment;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fee;
use App\Models\SecurityDeposit;
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

}