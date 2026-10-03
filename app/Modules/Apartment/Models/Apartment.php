<?php

namespace App\Modules\Apartment\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Apartment extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'photo',
        'address',
        'city',
        'state',
        'pincode',
        'type',
        'status',
    ];

    /**
     * Apartment owner
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}