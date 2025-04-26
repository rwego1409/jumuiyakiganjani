<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with(['user', 'subject'])
            ->when($request->filter, function($query) use ($request) {
                return $query->where('action', $request->filter);
            })
            ->when($request->search, function($query) use ($request) {
                return $query->where('description', 'like', "%{$request->search}%");
            });

        $activities = $query->latest()->paginate(20);
        $stats = $this->getActivityStats();

        return view('admin.activities.index', compact('activities', 'stats'));
    }

    private function getActivityStats()
    {
        return [
            'total' => Activity::count(),
            'this_week' => Activity::thisWeek()->count(),
            'this_month' => Activity::thisMonth()->count(),
            'by_type' => Activity::select('action', DB::raw('count(*) as count'))
                ->groupBy('action')
                ->get()
        ];
    }

    public function show(Activity $activity)
    {
        return view('admin.activities.show', compact('activity'));
    }

    public function export(Request $request)
    {
        $activities = Activity::with(['user', 'subject'])
            ->when($request->date_range, function($query) use ($request) {
                if ($request->date_range === 'week') {
                    return $query->thisWeek();
                }
                return $query->thisMonth();
            })
            ->latest()
            ->get();

        return (new ActivityExport($activities))->download('activities.xlsx');
    }
}
