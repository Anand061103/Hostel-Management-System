<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

   protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'hostel_id',
    'mobile_number',
    'address',
    'photo',
    'joining_date',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

   protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'joining_date' => 'date',
    ];
}
    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }
}
