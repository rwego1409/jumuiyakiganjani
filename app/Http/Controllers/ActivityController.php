<?php

namespace App\Http\Controllers;

use App\Models\MemberActivity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $activities = MemberActivity::with(['member.user'])
            ->latest()
            ->paginate(20);

        return view('admin.activities.index', compact('activities'));
    }

    public function show(MemberActivity $activity)
    {
        return view('admin.activities.show', compact('activity'));
    }
}
