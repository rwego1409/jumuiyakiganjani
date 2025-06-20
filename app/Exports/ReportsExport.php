<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromArray, WithHeadings, WithStyles
{
    protected $data;
    protected $headers;

    /**
     * Create a new export instance.
     *
     * @param mixed $data The data rows for the report.
     * @param array $headers The column headers for the report.
     */
    public function __construct($data, array $headers = [])
    {
        $this->data = $data instanceof \Illuminate\Support\Collection ? $data->toArray() : $data;
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->headers;
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A1:Z1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F3F4F6']
                ]
            ]
        ];
    }
}
