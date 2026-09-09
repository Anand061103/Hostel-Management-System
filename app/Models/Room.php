<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bed;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Room extends Model
{
    protected $fillable = [
        'room_number',
        'floor',
        'room_type',
        'status',
    ];

    public function beds(): HasMany
{
    return $this->hasMany(Bed::class);
}
}
