// MemberCourseContribution.php

<?php

// app/Models/Report.php

namespace App\Models;
use App\Models\Course;
use App\Models\Member;
use App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class MemberCourseContribution extends Model
{
    protected $fillable = ['member_id', 'course_id', 'amount', 'paid_amount', 'due_date', 'is_paid'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getProgressAttribute()
    {
        return ($this->paid_amount / $this->amount) * 100;
    }
}