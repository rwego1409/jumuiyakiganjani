<?php

namespace App\Models;

use App\Traits\HasWhatsAppReminders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contribution extends Model
{
    use HasFactory, HasWhatsAppReminders;

    protected $fillable = [
        'user_id', 
        'recorded_by',
        'member_id',
        'jumuiya_id',
        'amount',
        'contribution_date',
        'payment_method',
        'purpose',
        'status',
        'receipt_number',
            'recorded_by' ,
        'payment_reference'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'contribution_date' => 'datetime',
    ];

    // Member relationship (user making contribution)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Admin relationship (who recorded)
    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }


    // Relationships
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function jumuiya(): BelongsTo
    {
        return $this->belongsTo(Jumuiya::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class, 'member_course_contribution_id');
    }

    // Validation rules (reusable in requests)
    public static function validationRules(): array
    {
        return [
            'member_id' => 'required|exists:members,id',
            'jumuiya_id' => 'required|exists:jumuiyas,id',
            'amount' => 'required|numeric|min:1000|max:1000000000', // TZS range
            'contribution_date' => 'required|date|before_or_equal:today',
            'payment_method' => 'required|in:cash,mobile,bank',
            'purpose' => 'nullable|string|max:255',
            'status' => 'required|in:pending,confirmed,rejected',
            'receipt_number' => 'nullable|string|max:50|unique:contributions',
            'payment_reference' => 'nullable|string|unique:contributions,payment_reference',
        ];
    }

    public function formatMessage()
    {
        return "Dear {$this->member->user->name},\n\n"
            . "This is a reminder for your contribution of TZS " . number_format($this->amount) . " "
            . "due on {$this->due_date->format('M d, Y')}.\n\n"
            . "Currently paid: TZS " . number_format($this->total_paid) . "\n"
            . "Remaining: TZS " . number_format($this->remaining_amount) . "\n\n"
            . "Please make your payment to complete your contribution.\n\n"
            . "Best regards,\n"
            . config('app.name');
    }

    public function scheduleReminderBeforeDueDate($daysBeforeDue = 3)
    {
        if ($this->due_date && !$this->isPaid()) {
            $scheduledAt = $this->due_date->copy()->subDays($daysBeforeDue);
            
            if ($scheduledAt->isFuture()) {
                return $this->scheduleReminder(
                    $this->member->phone,
                    $this->formatMessage(),
                    $scheduledAt
                );
            }
        }
        return null;
    }

    public function isDue()
    {
        return $this->due_date && now()->greaterThan($this->due_date);
    }

    public function isPaid()
    {
        return $this->total_paid >= $this->amount;
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('amount');
    }

    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->total_paid;
    }
}