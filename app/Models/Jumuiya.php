<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jumuiya extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'description', 'chairperson_id', 'meeting_day', 'meeting_time', 'status'];

    public function chairperson()
    {
        return $this->belongsTo(User::class, 'chairperson_id');
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_jumuiya');
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
}