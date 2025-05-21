<?php

// app/Models/AdminNotification.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'recipients',
        'user_ids',
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