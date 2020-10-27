<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Skin extends Model
{
    protected $table = 'skins';

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function uses()
    {
        return $this->hasMany(User::class);
    }
}
