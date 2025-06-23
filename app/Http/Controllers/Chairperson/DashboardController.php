<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Member;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jumuiya = $user->jumuiyas()->first(); // Get the chairperson's jumuiya

        if (!$jumuiya) {
            return redirect()->route('dashboard')->with('error', 'No jumuiya assigned to your account.');
        }

        $cacheKey = "jumuiya_{$jumuiya->id}_dashboard_stats";

        $stats = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($jumuiya) {
            // Get the last 6 months for contribution trends
            $months = collect();
            for ($i = 5; $i >= 0; $i--) {
                $months->push(Carbon::now()->subMonths($i));
            }

            $contributionTrends = $months->map(function ($month) use ($jumuiya) {
                return [
                    'month' => $month->format('M Y'),
                    'amount' => Contribution::where('jumuiya_id', $jumuiya->id)
                        ->whereYear('contribution_date', $month->year)
                        ->whereMonth('contribution_date', $month->month)
                        ->sum('amount'),
                ];
            });

            // Get event participation stats
            $eventStats = Event::where('start_time', '<=', now())
                ->orderBy('start_time', 'desc')
                ->take(6)
                ->get()
                ->map(function ($event) {
                    return [
                        'name' => $event->title,
                        'attendance' => $event->attendees()->count(),
                    ];
                });

            return [
                'total_members' => Member::where('jumuiya_id', $jumuiya->id)->count(),
                'total_contributions' => Contribution::where('jumuiya_id', $jumuiya->id)->sum('amount'),
                'pending_contributions' => Contribution::where('jumuiya_id', $jumuiya->id)
                    ->where('status', 'pending')
                    ->count(),
                'recent_members' => Member::where('jumuiya_id', $jumuiya->id)
                    ->with('user')
                    ->latest()
                    ->take(5)
                    ->get(),
                'recent_contributions' => Contribution::where('jumuiya_id', $jumuiya->id)
                    ->with(['member.user'])
                    ->latest()
                    ->take(5)
                    ->get(),
                'upcoming_events' => Event::where('start_time', '>', now())
                    ->take(5)
                    ->get(),
                'contribution_trends' => [
                    'labels' => $contributionTrends->pluck('month'),
                    'data' => $contributionTrends->pluck('amount'),
                ],
                'event_stats' => [
                    'labels' => $eventStats->pluck('name'),
                    'data' => $eventStats->pluck('attendance'),
                ],
                'recent_activities' => \App\Models\Activity::whereHas('user', function($q) use ($jumuiya) {
                    $q->whereHas('member', function($q2) use ($jumuiya) {
                        $q2->where('jumuiya_id', $jumuiya->id);
                    });
                })
                ->latest()
                ->take(5)
                ->get(),
            ];
        });
        return view('chairperson.dashboard', compact('stats', 'jumuiya'));
    }
}


