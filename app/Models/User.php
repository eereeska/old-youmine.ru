<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
        'sub_expire_at' => 'datetime',
    ];

    public function skin()
    {
        return $this->belongsTo(Skin::class);
    }

    public function getDepositSum()
    {
        return $this->hasMany(Payment::class)->sum('sum');
    }
}