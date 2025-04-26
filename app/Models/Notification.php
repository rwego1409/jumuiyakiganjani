<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'contribution_id', 'reminder_date', 'status'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function contribution()
    {
        return $this->belongsTo(Contribution::class);
    }
}