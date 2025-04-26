<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Contribution;
use App\Exports\ReportsExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function generate($type, $format = 'pdf')
    {
        $data = $this->getReportData($type);
        $filename = $type . '_report_' . date('Y-m-d');

        return match($format) {
            'pdf' => PDF::loadView("admin.reports.$type", compact('data'))
                       ->download("$filename.pdf"),
            'excel' => Excel::download(new ReportsExport($data), "$filename.xlsx"),
            'csv' => Excel::download(new ReportsExport($data), "$filename.csv", \Maatwebsite\Excel\Excel::CSV),
            default => abort(400, 'Invalid format specified')
        };
    }

    private function getContributionsData()
    {
        $query = Contribution::with(['member.user'])->latest();
        
        if (request('start_date')) {
            $query->whereDate('created_at', '>=', request('start_date'));
        }
        
        if (request('end_date')) {
            $query->whereDate('created_at', '<=', request('end_date'));
        }
        
        return $query->get();
    }

    private function getMembersData()
    {
        return Member::with(['user', 'jumuiya'])->get();
    }

    private function getReportData($type)
    {
        return match($type) {
            'members' => $this->getMembersData(),
            'contributions' => $this->getContributionsData(),
            default => abort(404, 'Invalid report type')
        };
    }
}
