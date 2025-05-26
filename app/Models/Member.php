<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'jumuiya_id', 'phone', 'address', 'birth_date', 'joined_date', 'status', 'profile_picture',];

    protected $casts = [
        'birth_date' => 'date',
        'joined_date' => 'date'
    ];

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

    public function courseContributions()
    {
        return $this->belongsToMany(Course::class)
            ->withPivot('paid_amount', 'status')
            ->using(MemberCourseContribution::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_member');
    }

    // The payments made by the member
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // The reports related to the member
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function activeContributions()
    {
        return $this->hasMany(Contribution::class)->where('status', 'active');
    }

    public function inactiveContributions()
    {
        return $this->hasMany(Contribution::class)->where('status', 'inactive');
    }

    public function activeCourses()
    {
        return $this->belongsToMany(Course::class)->where('status', 'active');
    }

    public function inactiveCourses()
    {
        return $this->belongsToMany(Course::class)->where('status', 'inactive');
    }

    public function activePayments()
    {
        return $this->hasMany(Payment::class)->where('status', 'active');
    }

    public function inactivePayments()
    {
        return $this->hasMany(Payment::class)->where('status', 'inactive');
    }

    public function activities()
    {
        return $this->hasMany(MemberActivity::class)->latest();
    }

    public function getRecentActivities($limit = 5)
    {
        return $this->activities()
            ->with('member.user')
            ->limit($limit)
            ->get();
    }

    public function getContributionStats()
    {
        return [
            'total' => $this->contributions()->sum('amount'),
            'month' => $this->contributions()
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
            'count' => $this->contributions()->count()
        ];
    }
}
