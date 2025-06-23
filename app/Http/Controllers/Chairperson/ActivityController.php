<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $jumuiya = $user->jumuiyas()->first();
        $activities = Activity::whereHas('user', function($q) use ($jumuiya) {
                $q->whereHas('member', function($q2) use ($jumuiya) {
                    $q2->where('jumuiya_id', $jumuiya->id);
                });
            })
            ->latest()
            ->paginate(20);
        return view('chairperson.activities.index', compact('activities'));
    }
}
