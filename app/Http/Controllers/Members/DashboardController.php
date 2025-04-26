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
    $user->load(['member.jumuiya', 'member.contributions']);
    $member = $user->member;

    if (!$member) {
        return redirect()->route('profile.edit')->with('error', 'Please complete your profile first');
    }

    $jumuiya = $member->jumuiya;

    $completedPayments = Payment::where('member_id', $member->id)->where('status', 'completed')->count();
    $totalContributions = Contribution::where('member_id', $member->id)->sum('amount');
    $memberSince = optional($member->joined_date)->format('F Y');

    $recentPayments = Payment::where('member_id', $member->id)->orderByDesc('created_at')->limit(5)->get();
    $recentContributions = $member->contributions()->latest()->take(5)->get();

    // Corrected upcoming_events query:
    $events = Event::with('jumuiya')->latest()->paginate(10);

    $resources = Resource::paginate(10); // Paginate with 10 items per page
        // return view('member.resources.index', compact('resources'));

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


    $lineChartLabels = ['January', 'February', 'March', 'April']; // Example labels
    $lineChartData = [10, 20, 30, 40]; // Example data
    return view('member.dashboard', compact(
        'member', 'jumuiya', 'recentPayments', 'recentContributions',
        'events', 'resources', 'stats', 'community_data',
        'calendarEvents', 'contributionsChart', 'activityChart',
        'contributionGrowth', 'jumuiyaRank', 'totalJumuiyas', 'engagementScore',
        'lineChartLabels', 'lineChartData', 'memberSince', 'completedPayments', 'totalContributions'
    ));
}

    protected function getCommunityData($user)
    {
        return Cache::remember('community_data_' . $user->id, 3600, function () use ($user) {
            return [
                'total_members' => Member::count(),
                'total_jumuiyas' => Jumuiya::count(),
                'total_community_contributions' => Contribution::sum('amount'),
                'jumuiya_rank' => $this->getJumuiyaRank($user->member),
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
        if ($lastMonth == 0) return 0;
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
            ->map(function($item) {
                return [
                    'month' => Carbon::create()->month($item->month)->format('M'),
                    'amount' => $item->total
                ];
            });
    }

    private function getActivityChartData($member)
    {
        return [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'data' => [65, 59, 80, 81, 56, 55, 40]
        ];
    }

    private function getCalendarEvents($member)
{
    return Event::where('jumuiya_id', $member->jumuiya_id)  // Filter by member's community (jumuiya_id)
        ->get()
        ->map(function($event) {
            return [
                'title' => $event->title,
                'start' => $event->start_time->format('Y-m-d'),
                'url' => route('member.events.show', $event->id)
            ];
        });
}

}
