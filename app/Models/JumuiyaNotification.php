<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JumuiyaNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'jumuiya_id',
        'title',
        'message',
        'type',
        'recipient_type',
        'member_ids',
        'action_url',
        'created_by',
    ];

    protected $casts = [
        'member_ids' => 'array',
    ];

    public function jumuiya()
    {
        return $this->belongsTo(Jumuiya::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->jumuiya->members()
            ->when($this->recipient_type === 'specific', function ($query) {
                return $query->whereIn('id', $this->member_ids);
            });
    }

    public function readBy()
    {
        return User::whereHas('notifications', function ($query) {
            $query->where('data->notification_id', $this->id)
                  ->whereNotNull('read_at');
        });
    }
}
