<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ChairpersonReportsExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $headings;

    public function __construct($data, $headings = [])
    {
        $this->data = $data;
        // Always use provided headings if available
        $this->headings = !empty($headings) ? $headings : (!empty($data) ? array_keys($data[0]) : []);
    }

    public function collection()
    {
        return new Collection($this->data);
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
