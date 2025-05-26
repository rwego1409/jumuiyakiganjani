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
use Illuminate\Support\Str;

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
    // Validate request using Contribution model rules
    $validated = $request->validate(Contribution::validationRules());

    // Find the member to get the user_id
    $member = Member::findOrFail($validated['member_id']);
    $validated['user_id'] = $member->user_id;

    // Generate unique payment reference
    $validated['payment_reference'] = \Illuminate\Support\Str::uuid();

    // Generate unique receipt number (example format: RCPT-{timestamp}-{random})
    $validated['receipt_number'] = 'RCPT-' . time() . '-' . strtoupper(\Illuminate\Support\Str::random(6));

    if (auth()->user()->isAdmin()) {
        // If admin is recording, mark status as 'confirmed' and recorded_by as admin user id
        $validated['recorded_by'] = auth()->id();
        $validated['status'] = 'confirmed';
    } else {
        // If member self-submitting, assign recorded_by as first admin id
        $validated['recorded_by'] = User::where('role', 'admin')->first()->id;
        // Keep status from validated input (e.g., 'pending', 'paid', etc.)
    }

    // Create contribution record
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
        $validated = $request->validate([
            'reminder_date' => 'required|date|after:now',
        ]);

        $contribution->scheduleReminder(
            $contribution->member->phone,
            $contribution->formatMessage(),
            Carbon::parse($validated['reminder_date'])
        );

        return back()->with('success', 'WhatsApp reminder scheduled successfully');
    }

    public function cancelReminder(Contribution $contribution, $reminderId)
    {
        if ($contribution->cancelReminder($reminderId)) {
            return back()->with('success', 'Reminder cancelled successfully');
        }
        return back()->with('error', 'Could not cancel reminder');
    }

    public function sendNotification(Contribution $contribution)
    {
        try {
            // Send immediate notification to the member
            NotificationFacade::send(
                $contribution->member->user,
                new \App\Notifications\ContributionCreated($contribution)
            );

            return back()->with('success', 'Notification sent successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Could not send notification: ' . $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        $contributions = $this->getFilteredContributions($request);
        $pdf = PDF::loadView('admin.contributions.pdf', compact('contributions'));
        return $pdf->download('contributions-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $contributions = $this->getFilteredContributions($request);
        return Excel::download(new ContributionsExport($contributions), 'contributions-' . now()->format('Y-m-d') . '.xlsx');
    }

    protected function getFilteredContributions($request)
    {
        $query = Contribution::query()->with(['member.user', 'jumuiya']);

        if ($request->jumuiya_id) {
            $query->where('jumuiya_id', $request->jumuiya_id);
        }

        if ($request->date_from) {
            $query->whereDate('contribution_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('contribution_date', '<=', $request->date_to);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        return $query->latest();
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
