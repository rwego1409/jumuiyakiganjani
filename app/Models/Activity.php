<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'model_type',
        'model_id',
        'properties',
        'target_type',
        'target_id'
    ];

    protected $casts = [
        'properties' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo('model');
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month);
    }

    public function getActivityIcon()
    {
        return match($this->action) {
            'created' => 'plus-circle',
            'updated' => 'pencil',
            'deleted' => 'trash',
            'payment' => 'credit-card',
            'login' => 'login',
            default => 'bell'
        };
    }

    public function getActionColor()
    {
        return match($this->action) {
            'created' => 'green',
            'updated' => 'blue',
            'deleted' => 'red',
            'payment' => 'purple',
            'login' => 'indigo',
            default => 'gray'
        };
    }

    public function getFormattedActionAttribute()
    {
        return [
            'icon' => $this->getActivityIcon(),
            'color' => $this->getActionColor(),
            'label' => ucfirst($this->action)
        ];
    }

    public function getDisplayDateAttribute()
    {
        return $this->created_at->format('M d, Y h:i A');
    }

    public function getSummaryAttribute()
    {
        return sprintf(
            '%s %s %s',
            $this->user->name,
            $this->action,
            class_basename($this->model_type)
        );
    }
}
