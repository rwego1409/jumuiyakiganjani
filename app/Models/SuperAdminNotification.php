<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuperAdminNotification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'type',
        'recipients',
        'user_ids',
        'action_url',
        'created_by'
    ];

    protected $casts = [
        'recipients' => 'array',
        'user_ids' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
