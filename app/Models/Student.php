<?php

namespace App\Models;
use App\Models\BedAssignment;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

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

}