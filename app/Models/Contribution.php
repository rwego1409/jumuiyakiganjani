<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'jumuiya_id', 'amount', 'contribution_date', 'payment_method', 'purpose', 'status'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function jumuiya()
    {
        return $this->belongsTo(Jumuiya::class);
    }
}