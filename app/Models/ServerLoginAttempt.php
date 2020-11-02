<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerLoginAttempt extends Model
{
    protected $table = 'server_login_attempts';

    protected $fillable = [
        'user_id',
        'name',
        'ip'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}