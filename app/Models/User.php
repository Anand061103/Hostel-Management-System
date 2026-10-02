<?php

namespace App\Models;

use App\Modules\Hostel\Models\Hostel;
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
    'management_type',
    'pan_number',

    'bank_account_holder_name',
    'account_number',
    'ifsc_code',

    'address',
    'photo',
    'joining_date',
    'aadhaar_number',
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
    public function subscriptions()
{
    return $this->hasMany(\App\Models\Subscription::class);
}
}