<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'unitpay_payments';

    protected $fillable = [
        'unitpayId',
        'sum'
    ];
}