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
    ];

    protected $fillable = ['jumuiya_id', 'title', 'description', 'end_time', 'location', 'status'];

    public function jumuiya()
    {
        return $this->belongsTo(Jumuiya::class);
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
}