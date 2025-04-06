<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Event;
use App\Models\Member;
use App\Models\Activity;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Members
        $totalMembers = Member::count();

        // Member increase percentage (compared to last month)
        $lastMonthMembers = Member::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $memberIncreasePercentage = $lastMonthMembers > 0 ? round((($totalMembers - $lastMonthMembers) / $lastMonthMembers) * 100, 2) : 0;

        // Total Contributions
        $totalContributions = Contribution::sum('amount');

        // Contribution increase percentage (this month vs last month)
        $lastMonthContributions = Contribution::where('created_at', '>=', Carbon::now()->subMonth())->sum('amount');
        $contributionIncreasePercentage = $lastMonthContributions > 0 ? round((($totalContributions - $lastMonthContributions) / $lastMonthContributions) * 100, 2) : 0;

        // Upcoming Events - Fetch actual events data
        $upcomingEvents = Event::where('status', 'upcoming')->orderBy('start_time')->take(5)->get();
        $upcomingEventsCount = $upcomingEvents->count();  // Get the count of upcoming events

        // Determine the next event date
        $nextEvent = $upcomingEvents->first(); // Get the first upcoming event
        $nextEventDate = $nextEvent ? $nextEvent->start_time->format('F j, Y, g:i a') : 'N/A'; // If no event, return 'N/A'

        // Total Resources (example value, replace with actual logic if needed)
        $totalResources = 100; // This should be replaced with actual logic
        $recentResourcesCount = 5; // Replace with actual count of new resources this week

        // Recent Members (new members in the last month)
       // DashboardController.php
$recentMembers = Member::where('created_at', '>=', Carbon::now()->subMonth())
->orderBy('created_at', 'desc')
->paginate(5); // ← Change from get() to paginate()

        // Recent Activities (can be system logs or other activity data)
        $activities = Activity::orderBy('created_at', 'desc')->take(5)->get();

        // Passing the data to the view
        return view('admin.dashboard', compact(
            'totalMembers',
            'memberIncreasePercentage',
            'totalContributions',
            'contributionIncreasePercentage',
            'upcomingEvents',
            'upcomingEventsCount',
            'nextEventDate',  // Pass nextEventDate to the view
            'totalResources',
            'recentResourcesCount',
            'recentMembers',
            'activities'
        ));
    }
}
