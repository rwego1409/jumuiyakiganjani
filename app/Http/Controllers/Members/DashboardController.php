<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\{Event, Contribution, Jumuiya, Member, Resource, Payment};
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $member = $user->member;

        if (!$member) {
            return redirect()->route('profile.edit')->with('error', 'Please complete your profile first');
        }

        $jumuiya = $member->jumuiya;

        $completedPayments = Payment::where('member_id', $member->id)->where('status', 'completed')->count();
        $totalContributions = Contribution::where('member_id', $member->id)->sum('amount');
        $memberSince = $member->joined_date ? $member->joined_date->format('F j, Y') : '';

        $recentPayments = Payment::where('member_id', $member->id)->orderByDesc('created_at')->limit(5)->get();
        $recentContributions = $member->contributions()->latest()->limit(5)->get();

        $events = Event::with('jumuiya')
            ->where(function ($query) use ($member) {
                $query->where('jumuiya_id', $member->jumuiya_id)
                      ->orWhereNull('jumuiya_id');
            })
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();

        // Just show 10 latest resources (not paginated to avoid error on non-paginated view)
        $resources = Resource::whereNotNull('file_path')->latest()->paginate(10);

        $stats = [
            'completed_payments' => $completedPayments,
            'total_contributions' => $totalContributions,
            'member_since' => $memberSince,
        ];

        $community_data = $this->getCommunityData($user);
        $calendarEvents = $this->getCalendarEvents($member);
        $contributionsChart = $this->getContributionsChartData($member);
        $activityChart = $this->getActivityChartData($member);
        $contributionGrowth = $this->calculateContributionIncrease($member);
        $jumuiyaRank = $community_data['jumuiya_rank'];
        $totalJumuiyas = $community_data['total_jumuiyas'];

        $engagementScore = round(($completedPayments * 2 + $member->contributions->count() + $resources->count()) / 5);

        // Extract chart labels & data from contributions
        $lineChartLabels = $contributionsChart->pluck('month');
        $lineChartData = $contributionsChart->pluck('amount');

        // Fetch unread notifications using notifications() relationship
        $unreadCount = $user->notifications()->whereNull('read_at')->count();
        $notifications = $user->notifications()->whereNull('read_at')->latest()->take(5)->get();

        return view('member.dashboard', compact(
            'member', 'jumuiya', 'recentPayments', 'recentContributions',
            'events', 'resources', 'stats', 'community_data',
            'calendarEvents', 'contributionsChart', 'activityChart',
            'contributionGrowth', 'jumuiyaRank', 'totalJumuiyas', 'engagementScore',
            'lineChartLabels', 'lineChartData', 'completedPayments', 'totalContributions',
            'memberSince', 'resources', 'completedPayments', 'totalContributions',
            'unreadCount', 'notifications'
        ));
    }

    protected function getCommunityData($user)
    {
        $member = $user->member;
        $key = 'community_data_' . $user->id . '_' . $member->jumuiya_id;

        return Cache::remember($key, 3600, function () use ($member) {
            return [
                'total_members' => Member::count(),
                'total_jumuiyas' => Jumuiya::count(),
                'total_community_contributions' => Contribution::sum('amount'),
                'jumuiya_rank' => $this->getJumuiyaRank($member),
            ];
        });
    }

    protected function getJumuiyaRank($member)
    {
        if (!$member->jumuiya_id) return null;

        $ranked = Jumuiya::withSum('contributions', 'amount')
            ->orderByDesc('contributions_sum_amount')
            ->get()
            ->pluck('id')
            ->search($member->jumuiya_id);

        return $ranked !== false ? $ranked + 1 : null;
    }

    private function calculateContributionIncrease($member)
    {
        $currentMonth = $member->contributions()->whereMonth('created_at', now()->month)->sum('amount');
        $lastMonth = $member->contributions()->whereMonth('created_at', now()->subMonth()->month)->sum('amount');

        if ($lastMonth == 0) return null;

        return round((($currentMonth - $lastMonth) / $lastMonth) * 100, 2);
    }

    private function getContributionsChartData($member)
    {
        return $member->contributions()
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => Carbon::create()->month($item->month)->format('M'),
                    'amount' => $item->total
                ];
            });
    }

    private function getActivityChartData($member)
    {
        // Placeholder. You can replace with actual activity tracking logic
        return [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'data' => [65, 59, 80, 81, 56, 55, 40]
        ];
    }

    private function getCalendarEvents($member)
    {
        return Event::with('jumuiya')
            ->where(function ($query) use ($member) {
                $query->where('jumuiya_id', $member->jumuiya_id)
                      ->orWhereNull('jumuiya_id');
            })
            ->get()
            ->map(function ($event) {
                return [
                    'title' => $event->title,
                    'start' => $event->start_time->toIso8601String(),
                    'end' => optional($event->end_time)->toIso8601String(),
                    'color' => $event->jumuiya_id ? '#3B82F6' : '#10B981',
                    'url' => route('member.events.show', $event->id),
                    'extendedProps' => [
                        'description' => $event->description,
                        'location' => $event->location,
                        'jumuiya' => $event->jumuiya?->name ?? 'Community'
                    ]
                ];
            });
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);
        // Optional: Authorize access if needed
        return view('member.dashboard.show', compact('member'));
    }
}
