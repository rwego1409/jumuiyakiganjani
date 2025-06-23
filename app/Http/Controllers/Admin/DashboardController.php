<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Contribution;
use App\Models\Event;
use App\Models\Resource;
use App\Models\Jumuiya;
use App\Models\Course;
use App\Models\Activity;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {
        // Last 6 months of contributions
        $contributionsData = Contribution::selectRaw('DATE_FORMAT(created_at, "%M %Y") as month, YEAR(created_at) as year, MONTH(created_at) as month_num, SUM(amount) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('year', 'month_num', 'month')
            ->orderBy('year')
            ->orderBy('month_num')
            ->get();
            
        // Members growth by month
        $membersData = Member::selectRaw('DATE_FORMAT(created_at, "%M %Y") as month, YEAR(created_at) as year, MONTH(created_at) as month_num, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('year', 'month_num', 'month')
            ->orderBy('year')
            ->orderBy('month_num')
            ->get();
            
        // Events data by month (for chart)
        $eventsData = Event::selectRaw('DATE_FORMAT(created_at, "%M %Y") as month, YEAR(created_at) as year, MONTH(created_at) as month_num, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('year', 'month_num', 'month')
            ->orderBy('year')
            ->orderBy('month_num')
            ->get();
            
        // Resources data by month (for chart)
        $resourcesData = Resource::selectRaw('DATE_FORMAT(created_at, "%M %Y") as month, YEAR(created_at) as year, MONTH(created_at) as month_num, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('year', 'month_num', 'month')
            ->orderBy('year')
            ->orderBy('month_num')
            ->get();
            
        // Recent registrations with pagination
        $recentMembers = Member::with(['user', 'jumuiya'])
            ->latest()
            ->paginate(7);
            
        // New members in the last 7 days
        $newMembers = Member::with(['user', 'jumuiya'])
            ->where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->get();
            
        // Add activities query
        $activities = Activity::with('user')
            ->latest()
            ->paginate(10);
            
        // Add stats
        $totalMembers = Member::count();
        $totalContributions = Contribution::sum('amount');
        $memberIncreasePercentage = $this->calculateGrowthPercentage(Member::class);
        $contributionIncreasePercentage = $this->calculateGrowthPercentage(Contribution::class);
        $eventsIncreasePercentage = $this->calculateGrowthPercentage(Event::class);
        $resourcesIncreasePercentage = $this->calculateGrowthPercentage(Resource::class);
        
        // Get the count of upcoming events
        $upcomingEvents = Event::where('status', 'upcoming')->whereDate('start_time', '>=', now())->count();
        
        // Get the count of ongoing events
        $ongoingEvents = Event::where('status', 'ongoing')
            ->whereDate('start_time', '<=', now())
            ->whereDate('end_time', '>=', now())->count();
            
        // Get the count of completed events
        $completedEvents = Event::where('status', 'completed')->count();
        $totalEvents = Event::count();
        
        // Total resources
        $totalResources = Resource::count();
        
        return view('admin.dashboard', compact(
            'contributionsData',
            'membersData',
            'eventsData',
            'resourcesData',
            'recentMembers',
            'newMembers',
            'activities',
            'totalMembers',
            'totalContributions',
            'memberIncreasePercentage',
            'contributionIncreasePercentage',
            'eventsIncreasePercentage',
            'resourcesIncreasePercentage',
            'upcomingEvents',
            'ongoingEvents',
            'completedEvents',
            'totalResources',
            'totalEvents',
        ))->with('recentActivities', $activities);
    }
    
    private function calculateGrowthPercentage($model)
    {
        $lastMonth = now()->subMonth();
        $current = $model::whereMonth('created_at', now()->month)->count();
        $previous = $model::whereMonth('created_at', $lastMonth->month)->count();
        
        return $previous > 0 ? round(($current - $previous) / $previous * 100) : 0;
    }
}