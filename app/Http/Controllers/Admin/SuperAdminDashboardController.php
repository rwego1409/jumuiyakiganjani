<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use App\Models\Jumuiya;
use App\Models\Contribution;
use App\Models\Event;
use Illuminate\Http\Request;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_jumuiyas' => Jumuiya::count(),
            'total_members' => Member::count(),
            'total_contributions' => Contribution::sum('amount'),
            'admins' => User::where('role', 'admin')->count(),
            'chairpersons' => User::where('role', 'chairperson')->count(),
            'members' => User::where('role', 'member')->count(),
            'recent_events' => Event::latest()->take(5)->get(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_contributions' => Contribution::with('member.user')
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('admin.super.dashboard', compact('stats'));
    }
}
