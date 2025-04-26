<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'phone',
        'address',
        'birth_date',
        'status'
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

    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }

    public function activities()
    {
        return $this->hasManyThrough(MemberActivity::class, Member::class);
    }

    public function logActivity($type, $description, $metadata = [])
    {
        if ($this->member) {
            return $this->member->activities()->create([
                'activity_type' => $type,
                'description' => $description,
                'metadata' => $metadata,
                'ip_address' => request()->ip()
            ]);
        }
        return null;
    }
}
