<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembersController extends Controller
{
    public function index()
    {
        $jumuiya = Auth::user()->jumuiyas()->first();
        
        if (!$jumuiya) {
            return redirect()->route('chairperson.dashboard')
                ->with('error', 'No jumuiya assigned to your account.');
        }

        $members = Member::with('user')
            ->where('jumuiya_id', $jumuiya->id)
            ->latest()
            ->paginate(10);

        $stats = [
            'total_members' => $members->total(),
            'active_members' => Member::where('jumuiya_id', $jumuiya->id)
                ->where('status', 'active')
                ->count(),
            'inactive_members' => Member::where('jumuiya_id', $jumuiya->id)
                ->where('status', 'inactive')
                ->count()
        ];

        return view('chairperson.members.index', compact('members', 'stats'));
    }

    public function show(Member $member)
    {
        $jumuiya = Auth::user()->jumuiyas()->first();
        
        if (!$jumuiya || $member->jumuiya_id !== $jumuiya->id) {
            return redirect()->route('chairperson.members.index')
                ->with('error', 'Unauthorized action.');
        }

        // Load member's recent contributions
        $recentContributions = $member->contributions()
            ->latest()
            ->take(5)
            ->get();

        return view('chairperson.members.show', compact('member', 'recentContributions'));
    }
}
