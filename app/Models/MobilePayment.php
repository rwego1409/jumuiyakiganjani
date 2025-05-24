<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobilePayment extends Model
{
    protected $fillable = [
        'phone',
        'amount',
        'transaction_id',
        'response',
    ];

    protected $casts = [
        'response' => 'array',
        'amount' => 'decimal:2',
    ];
}
