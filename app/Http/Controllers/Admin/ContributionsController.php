<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contribution;
use App\Models\Member;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContributionRequest;
use App\Models\Jumuiya;
use App\Models\Course;
use App\Models\MemberContribution;
use App\Models\MemberJumuiya;
use App\Models\MemberCourse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ContributionsImport;
use App\Models\User;

class ContributionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Paginate the contributions (adjust the number to your preference, e.g., 10)
        $contributions = Contribution::with('member')->get();
    
        return view('admin.contributions.index', compact('contributions'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all members from the database
        $members = Member::with('user')->get();
        $jumuiyas = Jumuiya::all();
        // Define options for select dropdown
        $options = [
            'option1' => 'Option 1',
            'option2' => 'Option 2',
            'option3' => 'Option 3',
        ];

        // Return the create view with members and options
        return view('admin.contributions.create', compact('members', 'options','jumuiyas'));
    }


    public function import(Request $request)
    {
        // Validate the incoming file
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,ods|max:2048',  // Validate file type and size
        ]);

        // Process the file import
        try {
            Excel::import(new ContributionsImport, $request->file('file'));
            return redirect()->route('admin.contributions.index')->with('success', 'Contributions imported successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.contributions.index')->with('error', 'There was an error importing the file. Please try again.');
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    // In your Controller
    public function store(Request $request)
{
    $validated = $request->validate(Contribution::validationRules());
    
    // Get the member's user_id
    $member = Member::findOrFail($validated['member_id']);
    $validated['user_id'] = $member->user_id;

    // For admin submissions
    if(auth()->user()->isAdmin()) {
        $validated['recorded_by'] = auth()->id();
    }
    // For member self-submissions
    else {
        $validated['recorded_by'] = User::where('role', 'admin')->first()->id;
    }

    Contribution::create($validated);
    
    return redirect()->route('admin.contributions.index')
        ->with('success', 'Contribution recorded successfully');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the contribution by ID
        $contribution = Contribution::findOrFail($id);

        $contribution->contribution_date = Carbon::parse($contribution->contribution_date);

        // Return the show view with the contribution data
        return view('admin.contributions.show', compact('contribution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch the contribution by ID
        $contribution = Contribution::findOrFail($id);

        // Fetch all members from the database
        $members = Member::with('user')->get();

        // Define options for select dropdown
        $options = [
            'option1' => 'Option 1',
            'option2' => 'Option 2',
            'option3' => 'Option 3',
        ];

        // Return the edit view with contribution data, members, and options
        return view('admin.contributions.edit', compact('contribution', 'members', 'options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request
        $request->validate([
            'member_id' => 'required|integer',
            'jumuiya_id' => 'required|integer',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        // Find the contribution by ID and update it
        $contribution = Contribution::findOrFail($id);
        $contribution->update($request->all());

        // Redirect to the contributions index with success message
        return redirect()->route('admin.contributions.index')
            ->with('success', 'Contribution updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the contribution by ID and delete it
        $contribution = Contribution::findOrFail($id);
        $contribution->delete();

        // Redirect to the contributions index with success message
        return redirect()->route('admin.contributions.index')
            ->with('success', 'Contribution deleted successfully');
    }

    public function assignToMember(Request $request, Member $member)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date|after:today'
        ]);

        $member->contributions()->create($validated);

        return back()->with('success', 'Contribution assigned successfully!');
    }

    public function scheduleReminder(Request $request, Contribution $contribution)
    {
        $request->validate([
            'reminder_date' => 'required|date|after:now',
        ]);

        // Schedule a reminder
        Notification::create([
            'member_id' => $contribution->member_id,
            'contribution_id' => $contribution->id,
            'reminder_date' => $request->reminder_date,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Reminder scheduled successfully!');
    }

    public function sendReminders()
    {
        $notifications = Notification::where('status', 'pending')
            ->where('reminder_date', '<=', now())
            ->get();

        foreach ($notifications as $notification) {
            NotificationFacade::send(
                $notification->member->user,
                new \App\Notifications\ContributionReminder($notification->contribution)
            );

            $notification->update(['status' => 'sent']);
        }
    }
}
