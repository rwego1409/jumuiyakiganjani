<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'activity_type',
        'description',
        'metadata',
        'ip_address'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
