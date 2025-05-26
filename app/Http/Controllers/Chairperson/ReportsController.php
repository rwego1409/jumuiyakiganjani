<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Event;
use App\Models\Resource;
use App\Exports\ReportsExport;
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
    public function generate(Request $request, string $type = null, string $format = 'pdf')
    {
        $request->validate([
            'type' => 'required_without:type|in:members,events,resources',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'format' => 'nullable|in:pdf,xlsx'
        ]);

        $type = $type ?? $request->type;
        $format = $format ?? $request->format ?? 'pdf';
        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date) : null;
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date) : null;

        // Get report data based on type
        [$data, $headers, $title, $stats] = $this->getReportData($type, $startDate, $endDate);

        // Generate report in the specified format
        return $format === 'pdf' 
            ? $this->generatePdfReport($data, $headers, $title, $stats, $startDate, $endDate)
            : $this->generateExcelReport($data, $headers, $title);
    }

    /**
     * Get report data based on type.
     */
    private function getReportData(?string $type, ?Carbon $startDate, ?Carbon $endDate): array
    {
        $query = match($type) {
            'members' => Member::query(),
            'events' => Event::query(),
            'resources' => Resource::query(),
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
        return match($type) {
            'members' => $this->formatMembersReport($query),
            'events' => $this->formatEventsReport($query),
            'resources' => $this->formatResourcesReport($query),
            default => throw new \InvalidArgumentException('Invalid report type')
        };
    }

    /**
     * Format members report data.
     */
    private function formatMembersReport($query): array
    {
        $members = $query->with(['jumuiya'])->get();
        
        $data = $members->map(fn($member) => [
            'name' => $member->name,
            'email' => $member->email,
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
    private function generatePdfReport(array $data, array $headers, string $title, array $stats, ?Carbon $startDate, ?Carbon $endDate)
    {
        $pdf = PDF::loadView('chairperson.reports.exports.pdf', compact('data', 'headers', 'title', 'stats', 'startDate', 'endDate'));
        
        return $pdf->download(Str::slug($title) . '.pdf');
    }

    /**
     * Generate an Excel report.
     */
    private function generateExcelReport(array $data, array $headers, string $title)
    {
        return Excel::download(
            new ReportsExport($data, $headers), 
            Str::slug($title) . '.xlsx'
        );
    }
}
