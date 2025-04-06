<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        // Get activities, you can customize the query as needed
        $activities = Activity::orderBy('created_at', 'desc')->get();
        $activities = Activity::paginate(10);
        // Return the activities view and pass data
        return view('admin.activities.index', compact('activities'));
    }
}
