<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Exports\ChairpersonReportsExport;
use App\Services\ReportGenerator;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ReportsController extends Controller
{
    public function index()
    {
        return view('chairperson.reports.index');
    }

    public function generate(Request $request)
    {
        $type = $request->route('type') ?? $request->input('type');
        $format = $request->route('format') ?? $request->input('format', 'pdf');

        if (!in_array($type, ['members', 'events', 'resources'])) {
            return back()->with('error', 'Invalid report type.');
        }

        if (!in_array($format, ['pdf', 'xlsx', 'csv'])) {
            return back()->with('error', 'Invalid report format.');
        }

        // Get the current chairperson's jumuiya
        $jumuiya = auth()->user()->jumuiyas()->first();
        if (!$jumuiya) {
            return back()->with('error', 'No jumuiya found for this chairperson.');
        }

        // Get dates if provided
        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date) : null;
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date) : null;

        // Generate report data
        $generator = new ReportGenerator($jumuiya, $startDate, $endDate);
        $data = $generator->generate($type)->toArray();

        if (empty($data)) {
            return back()->with('error', 'No data available for the selected criteria.');
        }

        // Set report title
        $titles = [
            'members' => 'Members Report',
            'events' => 'Events Report',
            'resources' => 'Resources Report'
        ];
        $title = $titles[$type];

        // Generate filename
        $filename = Str::slug($title . '-' . $jumuiya->name . '-' . now()->format('Y-m-d'));

        // Return report in requested format
        return match($format) {
            'pdf' => $this->generatePdf($data, $title, $jumuiya, $startDate, $endDate, $filename),
            'xlsx' => $this->generateExcel($data, $filename, 'xlsx'),
            'csv' => $this->generateExcel($data, $filename, 'csv'),
        };
    }

    protected function generatePdf($data, $title, $jumuiya, $startDate, $endDate, $filename)
    {
        $pdf = PDF::loadView('chairperson.reports.pdf', [
            'data' => $data,
            'title' => $title,
            'jumuiya' => $jumuiya,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);

        return $pdf->download($filename . '.pdf');
    }

    protected function generateExcel($data, $filename, $format)
    {
        return Excel::download(
            new ChairpersonReportsExport($data),
            $filename . '.' . $format
        );
    }
}
