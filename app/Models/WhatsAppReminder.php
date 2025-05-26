<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'contribution_id',
        'phone_number',
        'message',
        'scheduled_at',
        'sent_at',
        'status',
        'error_message'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function contribution()
    {
        return $this->belongsTo(Contribution::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending')
                    ->where('scheduled_at', '<=', now());
    }
}
