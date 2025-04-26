<?php

namespace App\Http\Controllers\Members;
use App\Models\Event;
use App\Models\Member;
use App\Models\Jumuiya;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resource;
class MemberController extends Controller
{
    // Notifications
    public function notifications()
    {
        return view('member.notifications');
    }

    // Contributions
// app/Http/Controllers/Members/MemberController.php

public function indexContributions()
{
    // Assuming you have a Contribution model with a relationship to User
    $contributions = auth()->user()->contributions()
                        ->with('jumuiya') // Eager load the jumuiya relationship
                        ->latest()
                        ->get();

    return view('member.contributions.index', [
        'contributions' => $contributions
    ]);
}

    public function createContribution()
    {
        $member = auth()->user();
$jumuiyas = $member->jumuiyas; // Only get Jumuiyas for this member

        return view('member.contributions.create', compact('jumuiyas'));
    }

    public function storeContribution(Request $request)
    {
        // Contribution storage logic
    }

    public function showContribution($contribution)
    {
        return view('member.contributions.show', compact('contribution'));
    }

    public function downloadReceipt($contribution)
    {
        // Receipt download logic
    }

    // Resources
    // app/Http/Controllers/Members/MemberController.php


public function indexResources()
{
    $resources = Resource::orderBy('created_at', 'desc')
                ->paginate(10);
    
    return view('member.resources.index', compact('resources'));
}

public function showResource(Resource $resource)
{
    return view('member.resources.show', compact('resource'));
}

public function downloadResource(Resource $resource)
{
    // Verify the file exists
    $filePath = storage_path('app/public/' . $resource->file_path);
    
    if (!file_exists($filePath)) {
        abort(404);
    }

    // Increment download count
    $resource->increment('download_count');
    
    // Return the file download response
    return response()->download($filePath, $resource->original_filename);
}

    // Events
    public function indexEvents()
    {
        $events = Event::where('start_time', '>=', now())
                    ->orderBy('start_time')
                    ->paginate(10); // Paginate for better performance
    
        return view('member.events.index', compact('events'));
    }

    public function showEvent($event)
    {
        $event = Event::findOrFail($event); // Consider using route model binding
        return view('member.events.show', compact('event'));
    }

    public function attendEvent(Request $request, $event)
    {
        // Event attendance logic
    }

    public function eventConfirmation($event)
    {
        return view('member.events.confirmation', compact('event'));
    }

    // Activities
    public function indexActivities()
    {
        return view('member.activities.index');
    }

    public function showActivity($activity)
    {
        return view('member.activities.show', compact('activity'));
    }
}