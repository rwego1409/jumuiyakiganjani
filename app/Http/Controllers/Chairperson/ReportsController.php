<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Event;
use App\Models\Resource;
use App\Models\Jumuiya;
use App\Exports\ChairpersonReportsExport;
use App\Services\ReportGenerator;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ReportsController extends Controller
{
    /**
     * Display the reports index page.
     */
    public function index()
    {
        return view('chairperson.reports.index');
    }

    /**
     * Generate a report in the specified format.
     */
    public function generate(Request $request, $type, $format = 'pdf')
    {
        // Merge route params into request for validation
        $request->merge(['type' => $type, 'format' => $format]);
        $request->validate([
            'type' => 'required|in:members,events,resources',
            'format' => 'required|in:pdf,xlsx,csv',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        // Get the current chairperson's jumuiya
        $jumuiya = Jumuiya::where('chairperson_id', auth()->id())->first();
        if (!$jumuiya) {
            throw new \Exception('You are not assigned as chairperson to any Jumuiya.');
        }

        // Get dates if provided
        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date) : null;
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date) : null;

        // Get the data based on report type
        $data = [];
        $headers = [];
        $title = '';
        $stats = [];

        // Use route params directly
        // $type and $format are already set

        // Get report data based on type
        [$data, $headers, $title, $stats] = $this->getReportData($type, $startDate, $endDate);

        // Generate report in the specified format
        return match($format) {
            'pdf' => $this->generatePdfReport($data, $headers, $title, $stats, $startDate, $endDate),
            'xlsx', 'excel' => Excel::download(
                new ChairpersonReportsExport($data, $headers), 
                Str::slug($title) . '.xlsx'
            ),
            'csv' => Excel::download(
                new ChairpersonReportsExport($data, $headers), 
                Str::slug($title) . '.csv',
                \Maatwebsite\Excel\Excel::CSV
            ),
            default => throw new \InvalidArgumentException('Invalid format specified')
        };
    }

    /**
     * Get report data based on type.
     */
    private function getReportData(?string $type, ?Carbon $startDate, ?Carbon $endDate): array
    {
        $user = auth()->user();
        // Get the jumuiya where the user is chairperson
        $jumuiya = Jumuiya::where('chairperson_id', $user->id)->first();
        if (!$jumuiya) {
            throw new \Exception('You are not assigned as chairperson to any Jumuiya.');
        }
        $query = match($type) {
            'members' => Member::where('jumuiya_id', $jumuiya->id),
            'events' => Event::where('jumuiya_id', $jumuiya->id),
            'resources' => Resource::where('jumuiya_id', $jumuiya->id),
            default => throw new \InvalidArgumentException('Invalid report type')
        };

        // Apply date filters if provided
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Get data and format it based on type
        $data = $query->get();
        $headers = [];
        $stats = [];

        switch($type) {
            case 'members':
                $data = $data->map(function ($member) {
                    return [
                        'Name' => $member->name,
                        'Email' => $member->user->email,
                        'Phone' => $member->user->phone,
                        'Status' => ucfirst($member->status),
                        'Joined Date' => $member->created_at->format('d/m/Y')
                    ];
                });
                $headers = ['Name', 'Email', 'Phone', 'Status', 'Joined Date'];
                $title = 'Members Report';
                break;

            case 'events':
                $data = $data->map(function ($event) {
                    return [
                        'Name' => $event->name,
                        'Description' => Str::limit($event->description, 100),
                        'Start Time' => $event->start_time->format('d/m/Y H:i'),
                        'End Time' => $event->end_time->format('d/m/Y H:i'),
                        'Location' => $event->location,
                        'Attendees' => $event->attendees->count()
                    ];
                });
                $headers = ['Name', 'Description', 'Start Time', 'End Time', 'Location', 'Attendees'];
                $title = 'Events Report';
                break;

            case 'resources':
                $data = $data->map(function ($resource) {
                    return [
                        'Title' => $resource->title,
                        'Type' => ucfirst($resource->type),
                        'Size' => number_format($resource->size / 1024, 2) . ' KB',
                        'Downloads' => $resource->download_count ?? 0,
                        'Created At' => $resource->created_at->format('d/m/Y')
                    ];
                });
                $headers = ['Title', 'Type', 'Size', 'Downloads', 'Created At'];
                $title = 'Resources Report';
                break;
        }

        return [$data, $headers, $title, $stats];
    }

    /**
     * Format members report data.
     */
    private function formatMembersReport($query): array
    {
        $members = $query->with(['user', 'jumuiya'])->get();
        
        $data = $members->map(fn($member) => [
            'name' => $member->user?->name ?? '-',
            'email' => $member->user?->email ?? '-',
            'phone' => $member->phone,
            'jumuiya' => $member->jumuiya?->name ?? '-',
            'status' => Str::ucfirst($member->status),
            'joined' => $member->created_at->format('M d, Y'),
        ])->toArray();

        $headers = ['Name', 'Email', 'Phone', 'Jumuiya', 'Status', 'Joined'];
        $title = 'Members Report';
        
        $stats = [
            'total_members' => $members->count(),
            'active_members' => $members->where('status', 'active')->count(),
            'inactive_members' => $members->where('status', 'inactive')->count(),
        ];

        return [$data, $headers, $title, $stats];
    }

    /**
     * Format events report data.
     */
    private function formatEventsReport($query): array
    {
        $events = $query->get();
        
        $data = $events->map(fn($event) => [
            'name' => $event->name,
            'date' => $event->start_time->format('M d, Y H:i'),
            'location' => $event->location,
            'status' => Str::ucfirst($event->status),
            'created' => $event->created_at->format('M d, Y'),
        ])->toArray();

        $headers = ['Name', 'Date', 'Location', 'Status', 'Created'];
        $title = 'Events Report';
        
        $stats = [
            'total_events' => $events->count(),
            'upcoming_events' => $events->where('status', 'upcoming')->count(),
            'ongoing_events' => $events->where('status', 'ongoing')->count(),
            'completed_events' => $events->where('status', 'completed')->count(),
        ];

        return [$data, $headers, $title, $stats];
    }

    /**
     * Format resources report data.
     */
    private function formatResourcesReport($query): array
    {
        $resources = $query->get();
        
        $data = $resources->map(fn($resource) => [
            'name' => $resource->name,
            'type' => Str::ucfirst($resource->type),
            'status' => Str::ucfirst($resource->status),
            'created' => $resource->created_at->format('M d, Y'),
        ])->toArray();

        $headers = ['Name', 'Type', 'Status', 'Created'];
        $title = 'Resources Report';
        
        $stats = [
            'total_resources' => $resources->count(),
            'active_resources' => $resources->where('status', 'active')->count(),
            'inactive_resources' => $resources->where('status', 'inactive')->count(),
            'by_type' => $resources->groupBy('type')->map->count(),
        ];

        return [$data, $headers, $title, $stats];
    }

    /**
     * Generate a PDF report.
     */
    private function generatePdfReport($data, $headers, $title, $stats, $startDate, $endDate)
    {
        // Ensure data is an array
        if ($data instanceof \Illuminate\Support\Collection) {
            $data = $data->toArray();
        }

        // Get current jumuiya
        $jumuiya = Jumuiya::where('chairperson_id', auth()->id())->first();

        // Prepare view data
        $viewData = [
            'data' => $data,
            'headers' => $headers,
            'title' => $title,
            'stats' => $stats,
            'jumuiya' => $jumuiya,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'type' => request('type') // Add the type from the request
        ];

        $pdf = PDF::loadView('chairperson.reports.pdf', $viewData);
        
        return $pdf->download(Str::slug($title) . '.pdf');
    }

    /**
     * Generate an Excel report.
     */    private function generateExcelReport($data, $headers, $title)
    {
        // Ensure data is an array
        if ($data instanceof \Illuminate\Support\Collection) {
            $data = $data->toArray();
        }

        return Excel::download(
            new ChairpersonReportsExport($data),
            Str::slug($title) . '.xlsx'
        );
    }
}
