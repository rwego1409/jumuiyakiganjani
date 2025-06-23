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

    public function generate($type, $format, Request $request)
    {
        $user = auth()->user();
        $jumuiyaIds = $user->jumuiyas()->pluck('id')->toArray();
        if (empty($jumuiyaIds)) {
            abort(403, 'No Jumuiya assigned to your account.');
        }
        $start_date = $request->input('start_date', now()->startOfYear()->toDateString());
        $end_date = $request->input('end_date', now()->endOfDay()->toDateString());
        $dateRange = [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];

        if ($type === 'members') {
            $members = \App\Models\Member::with(['user', 'jumuiya'])
                ->whereIn('jumuiya_id', $jumuiyaIds)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->get();

            if ($format === 'pdf') {
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('chairperson.reports.members_pdf', compact('members'));
                return $pdf->download('members_report.pdf');
            } elseif ($format === 'excel' || $format === 'xlsx') {
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\MembersExport($dateRange, $jumuiyaIds), 'members_report.xlsx');
            } elseif ($format === 'csv') {
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\MembersExport($dateRange, $jumuiyaIds), 'members_report.csv', \Maatwebsite\Excel\Excel::CSV);
            }
        }
        if ($type === 'events') {
            $eventsQuery = \App\Models\Event::whereIn('jumuiya_id', $jumuiyaIds)
                ->whereBetween('created_at', [$start_date, $end_date]);
            $events = $eventsQuery->get();
            if ($format === 'pdf') {
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('chairperson.reports.events_pdf', ['events' => $events]);
                return $pdf->download('events_report.pdf');
            } elseif ($format === 'excel' || $format === 'xlsx') {
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\EventsExport($eventsQuery), 'events_report.xlsx');
            } elseif ($format === 'csv') {
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\EventsExport($eventsQuery), 'events_report.csv', \Maatwebsite\Excel\Excel::CSV);
            }
        }
        if ($type === 'resources') {
            $resourcesQuery = \App\Models\Resource::whereIn('jumuiya_id', $jumuiyaIds)
                ->whereBetween('created_at', [$start_date, $end_date]);
            $resources = $resourcesQuery->get();
            if ($format === 'pdf') {
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('chairperson.reports.resources_pdf', ['resources' => $resources]);
                return $pdf->download('resources_report.pdf');
            } elseif ($format === 'excel' || $format === 'xlsx') {
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ResourcesExport($resourcesQuery), 'resources_report.xlsx');
            } elseif ($format === 'csv') {
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ResourcesExport($resourcesQuery), 'resources_report.csv', \Maatwebsite\Excel\Excel::CSV);
            }
        }
        abort(404, 'Report type or format not supported.');
    }
}
