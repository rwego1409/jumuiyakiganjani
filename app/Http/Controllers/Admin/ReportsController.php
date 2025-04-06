<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Contribution;
use App\Models\Event;
use App\Exports\MembersExport;
use App\Exports\ContributionsExport;
use App\Exports\EventsExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportsController extends Controller
{
    /**
     * Display the reports dashboard
     */
    public function index()
    {
        $stats = [
            'members_count' => Member::count(),
            'total_contributions' => Contribution::sum('amount'),
            'upcoming_events' => Event::upcoming()->count(),
            'latest_members' => Member::latest()->take(5)->get(),
            'recent_contributions' => Contribution::with('member')->latest()->take(5)->get()
        ];

        return view('admin.reports.index', compact('stats'));
    }

    /**
     * Show the form for creating a custom report
     */
    public function create()
    {
        return view('admin.reports.create');
    }

    /**
     * Generate the requested report
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:members,contributions,events',
            'format' => 'required|in:pdf,excel,csv',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $fileName = str($validated['type'])->singular()->append('-report-') . now()->format('Ymd-His');

        switch ($validated['type']) {
            case 'members':
                return $this->handleMemberReport($validated, $fileName);
                
            case 'contributions':
                return $this->handleContributionReport($validated, $fileName);
                
            case 'events':
                return $this->handleEventReport($validated, $fileName);
        }
    }

    protected function handleMemberReport($data, $fileName)
    {
        $query = Member::with(['contributions', 'events']);
        
        if ($data['format'] === 'pdf') {
            $members = $query->get();
            $pdf = PDF::loadView('admin.reports.exports.members-pdf', compact('members'));
            return $pdf->download("$fileName.pdf");
        }

        return Excel::download(new MembersExport($query), "$fileName.xlsx");
    }

    protected function handleContributionReport($data, $fileName)
    {
        $query = Contribution::with('member')
            ->when($data['start_date'], fn($q) => $q->whereDate('created_at', '>=', $data['start_date']))
            ->when($data['end_date'], fn($q) => $q->whereDate('created_at', '<=', $data['end_date']));

        if ($data['format'] === 'pdf') {
            $contributions = $query->get();
            $pdf = PDF::loadView('admin.reports.exports.contributions-pdf', compact('contributions'));
            return $pdf->download("$fileName.pdf");
        }

        return Excel::download(new ContributionsExport($query), "$fileName.{$data['format']}");
    }

    protected function handleEventReport($data, $fileName)
    {
        $query = Event::with(['attendees', 'organizer'])
            ->when($data['start_date'], fn($q) => $q->whereDate('event_date', '>=', $data['start_date']))
            ->when($data['end_date'], fn($q) => $q->whereDate('event_date', '<=', $data['end_date']));

        if ($data['format'] === 'pdf') {
            $events = $query->get();
            $pdf = PDF::loadView('admin.reports.exports.events-pdf', compact('events'));
            return $pdf->download("$fileName.pdf");
        }

        return Excel::download(new EventsExport($query), "$fileName.{$data['format']}");
    }

    /**
     * Display a generated report
     */
    public function show(string $id)
    {
        // If you need to show stored reports
        $report = Report::findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }
}