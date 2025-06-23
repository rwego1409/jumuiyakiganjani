<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    public function index()
    {
        // You can fetch activities from your Activity model here
        // $activities = Activity::latest()->paginate(20);
        // return view('admin.activities.index', compact('activities'));
        return view('admin.activities.index'); // Placeholder view
    }
}
