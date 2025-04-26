<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;
    protected $type;

    public function __construct($data)
    {
        $this->data = $data;
        $this->type = $data->first() instanceof Member ? 'members' : 'contributions';
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->type === 'members' 
            ? ['Name', 'Phone', 'Jumuiya', 'Joined Date', 'Status']
            : ['Date', 'Member', 'Amount', 'Status'];
    }

    public function map($row): array
    {
        if ($this->type === 'members') {
            return [
                $row->user?->name ?? 'N/A',
                $row->phone ?? 'N/A',
                $row->jumuiya?->name ?? 'N/A',
                $row->created_at?->format('Y-m-d') ?? 'N/A',
                $row->status ?? 'N/A'
            ];
        }

        return [
            $row->created_at?->format('Y-m-d') ?? 'N/A',
            $row->member?->user?->name ?? 'N/A',
            number_format($row->amount ?? 0, 2),
            $row->status ?? 'N/A'
        ];
    }
}
