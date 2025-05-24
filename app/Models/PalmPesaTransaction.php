<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PalmPesaTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'phone',
        'amount',
        'status',
        'api_response',
        'currency'
    ];
}