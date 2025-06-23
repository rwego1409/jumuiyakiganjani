<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $casts = [
        'start_time' => 'datetime',  // This will automatically cast start_time to a Carbon instance
        'end_time' => 'datetime',
    ];

    protected $fillable = ['title', 'description', 'start_time', 'end_time', 'location', 'status'];

    public function jumuiyas()
    {
        return $this->belongsToMany(Jumuiya::class, 'event_jumuiya');
    }

    public function scopeUpcoming($query)
{
    return $query->where('status', 'upcoming')
        ->where('start_time', '>', now());
}

    public function scopePast($query)
{
    return $query->where('status', 'past')
        ->where('end_time', '<', now());
}

    public function scopeOngoing($query)
{
    return $query->where('status', 'ongoing')
        ->where('start_time', '<=', now())
        ->where('end_time', '>=', now());
}
// In app/Models/Event.php
public function attendees()
{
    return $this->belongsToMany(User::class, 'event_attendees')
        ->withPivot('created_at')
        ->withTimestamps();
}

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}
}