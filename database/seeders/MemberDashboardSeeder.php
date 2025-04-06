<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\{Event, Contribution, Jumuiya, Resource};
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Eager load relationships with fallbacks
        $user->load(['member.jumuiya', 'member.contributions']);
        
        // Redirect if no member profile exists
        if (!$user->member) {
            return redirect()->route('profile.edit')
                ->with('error', 'Please complete your profile first');
        }

        // Get data with unbiased approach
        $data = [
            'user' => $user,
            'member' => $user->member,
            'jumuiya' => $user->member->jumuiya,
            'stats' => $this->getMemberStats($user),
            'community_data' => $this->getCommunityData($user),
            'upcoming_events' => $this->getEvents($user),
            'recent_resources' => $this->getRecentResources(),
            'recent_contributions' => $this->getContributions($user),
        ];

        return view('member.dashboard', $data);
    }

    protected function getMemberStats($user)
    {
        // Personal contribution stats
        $total_contributions = $user->member->contributions->sum('amount');
        
        $last_month = $user->member->contributions()
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->sum('amount');
        
        $increase = $last_month > 0 
            ? round((($total_contributions - $last_month) / $last_month) * 100, 2)
            : ($total_contributions > 0 ? 100 : 0);

        return [
            'total_contributions' => $total_contributions,
            'contribution_increase' => $increase,
            'contribution_count' => $user->member->contributions->count(),
            'member_since' => $user->member->joined_date->diffForHumans(),
        ];
    }

    protected function getCommunityData($user)
    {
        // Community-wide statistics (not biased to member's jumuiya)
        return [
            'total_members' => Member::count(),
            'total_jumuiyas' => Jumuiya::count(),
            'total_community_contributions' => Contribution::sum('amount'),
            'jumuiya_rank' => $this->getJumuiyaRank($user),
        ];
    }

    protected function getJumuiyaRank($user)
    {
        if (!$user->member->jumuiya_id) return null;
        
        // Get jumuiyas ranked by total contributions
        $ranked = Jumuiya::withSum('contributions', 'amount')
            ->orderByDesc('contributions_sum_amount')
            ->get()
            ->pluck('id')
            ->search($user->member->jumuiya_id);
            
        return $ranked !== false ? $ranked + 1 : null;
    }

    protected function getEvents($user)
    {
        // Get events with priority:
        // 1. Member's jumuiya events
        // 2. General events (no jumuiya specified)
        // 3. Other jumuiya events (as "community events")
        return Event::where(function($query) use ($user) {
                $query->where('jumuiya_id', $user->member->jumuiya_id)
                      ->orWhereNull('jumuiya_id');
            })
            ->where('start_time', '>', now())
            ->orderBy('start_time')
            ->take(5)
            ->get();
    }

    protected function getRecentResources()
    {
        // Get latest resources available to all members
        return Resource::latest()
            ->take(5)
            ->get();
    }

    protected function getContributions($user)
    {
        // Get member's recent contributions with related data
        return $user->member->contributions()
            ->with(['jumuiya'])
            ->latest()
            ->take(5)
            ->get();
    }
}