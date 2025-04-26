<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contribution extends Model
{
    use HasFactory;

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
        'receipt_number'
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
            'receipt_number' => 'nullable|string|max:50|unique:contributions'
        ];
    }
}