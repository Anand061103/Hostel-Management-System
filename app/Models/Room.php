<?php

namespace App\Models;
use App\Models\Bed;
use App\Models\Hostel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
   protected $fillable = [
    'room_number',
    'floor',
    'room_type',
    'status',
    'hostel_id',
];
    public function beds(): HasMany
    {
        return $this->hasMany(Bed::class);
    }

    public function hostel(): BelongsTo
    {
        return $this->belongsTo(Hostel::class);
    }
}
