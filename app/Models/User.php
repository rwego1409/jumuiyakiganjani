<?php

namespace App\Models;

use App\Traits\ReceivesWhatsAppNotifications;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, ReceivesWhatsAppNotifications;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'phone',
        'address',
        'birth_date',
        'status',
        'whatsapp_notifications_enabled'
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

    /**
     * All possible roles in the system
     */
    const ROLES = [
        'super_admin',
        'admin',
        'chairperson',
        'member'
    ];

    /**
     * Check if user is a super admin
     */
    public function isSuper_Admin()
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin' || $this->isSuper_Admin();
    }

    /**
     * Check if user is a chairperson
     */
    public function isChairperson() 
    {
        return $this->role === 'chairperson';
    }

    /**
     * Check if user is a member
     */
    public function isMember()
    {
        return $this->role === 'member';
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->role === $role) {
                return true;
            }
        }
        return false;
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

    /**
     * Get the Jumuiyas that this admin manages.
     */
    public function managedJumuiyas()
    {
        return $this->belongsToMany(Jumuiya::class, 'jumuiya_managers', 'user_id', 'jumuiya_id')
                    ->withTimestamps();
    }
}
