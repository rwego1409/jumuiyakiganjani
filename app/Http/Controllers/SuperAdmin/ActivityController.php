<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::latest()->paginate(30);
        return view('super_admin.activities.index', compact('activities'));
    }

    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        return view('super_admin.activities.show', compact('activity'));
    }
}
