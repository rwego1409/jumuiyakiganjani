<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function member()
{
    return $this->hasOne(Member::class)->withDefault();
}
    public function jumuiyas()
    {
        return $this->hasMany(Jumuiya::class, 'chairperson_id');
    }
    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function jumuiya()
    {
        return $this->belongsTo(Jumuiya::class);
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isChairperson()
    {
        return $this->role === 'chairperson';
    }

    public function isMember()
    {
        return $this->role === 'member';
    }
}