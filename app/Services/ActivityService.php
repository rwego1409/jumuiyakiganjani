<?php

namespace App\Services;

use App\Models\MemberActivity;
use App\Models\Member;
use Illuminate\Support\Facades\Request;

class ActivityService
{
    public function log(Member $member, string $type, string $description, array $metadata = []): MemberActivity
    {
        return MemberActivity::create([
            'member_id' => $member->id,
            'activity_type' => $type,
            'description' => $description,
            'metadata' => $metadata,
            'ip_address' => Request::ip()
        ]);
    }

    public function getRecentActivities(Member $member, int $limit = 10)
    {
        return MemberActivity::where('member_id', $member->id)
            ->latest()
            ->limit($limit)
            ->get();
    }
}
