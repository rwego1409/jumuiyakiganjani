<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\Member;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function generate(Request $request)
    {
        $type = $request->type;
        $dateRange = $request->date_range;
        
        switch($type) {
            case 'contributions':
                $data = Contribution::with('member')
                    ->when($dateRange, function($query) use ($dateRange) {
                        return $query->whereBetween('created_at', explode(' - ', $dateRange));
                    })->get();
                break;
            case 'members':
                $data = Member::with('jumuiya')->get();
                break;
            default:
                return back()->with('error', 'Invalid report type');
        }

        $pdf = PDF::loadView("admin.reports.{$type}", compact('data', 'dateRange'));
        
        return $pdf->download("{$type}_report.pdf");
    }
}
