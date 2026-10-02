<?php

namespace App\Modules\Hostel\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hostel extends Model
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
    'phone',
    'email',
    'status',
];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}