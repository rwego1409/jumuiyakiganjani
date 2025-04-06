<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'jumuiya_id', 'phone', 'address', 'birth_date', 'joined_date', 'status'];

    // The user that owns the member
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // The jumuiya that the member belongs to
    public function jumuiya()
    {
        return $this->belongsTo(Jumuiya::class);
    }

    // The contributions made by the member
    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    // Events related to the member through jumuiya (optional if events belong to jumuiya)
    public function events()
    {
        return $this->belongsToMany(Event::class, 'member_event', 'member_id', 'event_id');
    }
}
