<?php

// app/Models/Report.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Course.php
class Course extends Model
{
    protected $fillable = ['name', 'description', 'default_amount', 'due_date', 'is_active'];

    public function contributions()
    {
        return $this->hasMany(MemberCourseContribution::class);
    }

    public function members()
{
    return $this->belongsToMany(Member::class, 'course_member');
}
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getProgressAttribute()
    {
        return ($this->paid_amount / $this->amount) * 100;
    }
    public function getTotalContributionsAttribute()
    {
        return $this->contributions()->sum('paid_amount');
    }
    public function getTotalMembersAttribute()
    {
        return $this->members()->count();
    }
    public function getTotalPaymentsAttribute()
    {
        return $this->payments()->sum('amount');
    }
    public function getTotalDueAttribute()
    {
        return $this->amount - $this->paid_amount;
    }
    public function getTotalPaidAttribute()
    {
        return $this->paid_amount;
    }
    public function getTotalUnpaidAttribute()
    {
        return $this->amount - $this->paid_amount;
    }
    public function getTotalPaidMembersAttribute()
    {
        return $this->members()->where('is_paid', true)->count();
    }
    public function getTotalUnpaidMembersAttribute()
    {
        return $this->members()->where('is_paid', false)->count();
    }
    public function getTotalPaidAmountAttribute()
    {
        return $this->payments()->where('status', 'paid')->sum('amount');
    }
    public function getTotalUnpaidAmountAttribute()
    {
        return $this->payments()->where('status', 'unpaid')->sum('amount');
    }       
}



