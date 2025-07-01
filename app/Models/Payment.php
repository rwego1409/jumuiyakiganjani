<?php

/// app/Models/Payment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount',
        'payment_method',
        'transaction_id',
        'member_id',
        'course_id',
        'reference',
        'status',
        'user_id',
        'payment_data',
        // other fields
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}