<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportExport implements FromCollection
{
    protected $report;

    // Constructor to pass the report data
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    // This function will return the collection of data for export
    public function collection()
    {
        return $this->report->members;  // Adjust this according to your report structure
    }
}
