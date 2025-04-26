<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Contribution;
use App\Exports\ReportsExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportsController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function generate(Request $request, string $type, string $format = 'pdf')
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $data = $this->getReportData($type, $validated);
        $filename = $this->generateFilename($type, $validated);

        return $this->exportReport($data, $format, $filename, $type);
    }

    private function getContributionsData(array $filters)
    {
        return Contribution::with(['member.user'])
            ->when($filters['start_date'] ?? null, function($query) use ($filters) {
                $query->whereDate('created_at', '>=', $filters['start_date']);
            })
            ->when($filters['end_date'] ?? null, function($query) use ($filters) {
                $query->whereDate('created_at', '<=', $filters['end_date']);
            })
            ->latest()
            ->get();
    }

    private function getMembersData(array $filters)
    {
        return Member::with(['user', 'jumuiya'])
            ->when($filters['start_date'] ?? null, function($query) use ($filters) {
                $query->whereDate('created_at', '>=', $filters['start_date']);
            })
            ->when($filters['end_date'] ?? null, function($query) use ($filters) {
                $query->whereDate('created_at', '<=', $filters['end_date']);
            })
            ->get();
    }


    private function generateFilename(string $type, array $filters): string
    {
        $baseName = $type . '_report_' . now()->format('Y-m-d');
        
        if(isset($filters['start_date']) || isset($filters['end_date'])) {
            $start = $filters['start_date'] ?? 'start';
            $end = $filters['end_date'] ?? 'end';
            return "{$baseName}_from_{$start}_to_{$end}";
        }
        
        return $baseName;
    }

    private function exportReport($data, string $format, string $filename, string $type): BinaryFileResponse
{
    return match($format) {
        'pdf' => $this->handlePdfExport($data, $filename, $type),
        'excel' => Excel::download(new ReportsExport($data), "$filename.xlsx"),
        'csv' => Excel::download(new ReportsExport($data), "$filename.csv", \Maatwebsite\Excel\Excel::CSV),
        default => abort(400, 'Invalid format specified')
    };
}

private function handlePdfExport($data, string $filename, string $type): BinaryFileResponse
{
    $tempPath = storage_path("app/temp/{$filename}.pdf");
    
    // Ensure directory exists
    if (!file_exists(dirname($tempPath))) {
        mkdir(dirname($tempPath), 0755, true);
    }

    // Generate and save PDF
    PDF::loadView("admin.reports.{$type}", compact('data'))
        ->setPaper('a4', 'landscape')
        ->save($tempPath);

    // Create download response
    return response()->download($tempPath, "{$filename}.pdf")
        ->deleteFileAfterSend(true);
}

private function getEventsData(array $filters)
{
    return Event::with(['attendees', 'organization'])
        ->when($filters['start_date'] ?? null, function($query) use ($filters) {
            $query->whereDate('event_date', '>=', $filters['start_date']);
        })
        ->when($filters['end_date'] ?? null, function($query) use ($filters) {
            $query->whereDate('event_date', '<=', $filters['end_date']);
        })
        ->latest()
        ->get();
}

// Update getReportData method
private function getReportData(string $type, array $filters)
{
    return match($type) {
        'members' => $this->getMembersData($filters),
        'contributions' => $this->getContributionsData($filters),
        'events' => $this->getEventsData($filters),
        default => abort(404, 'Invalid report type')
    };
}
}