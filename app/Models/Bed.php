<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Student;
use App\Models\BedAssignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bed extends Model
{
    protected $fillable = [
        'room_id',
        'bed_number',
        'status',
        'student_id',
    ];

   public function room(): BelongsTo
{
    return $this->belongsTo(Room::class);
}

public function student(): BelongsTo
{
    return $this->belongsTo(Student::class);
}

public function assignments(): HasMany
{
    return $this->hasMany(BedAssignment::class);
}

public function currentAssignment()
{
    return $this->hasOne(BedAssignment::class)
        ->whereNull('end_date')
        ->latestOfMany();
}



}