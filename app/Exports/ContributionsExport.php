<?php

namespace App\Exports;

use App\Models\Contribution;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContributionsExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Contribution::with('member');

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('contribution_date', [$this->startDate, $this->endDate]);
        }

        return $query->get()->map(function ($contribution) {
            return [
                'Member' => $contribution->member->name,
                'Amount' => $contribution->amount,
                'Date' => $contribution->contribution_date->format('M d, Y'),
                'Payment Method' => ucfirst($contribution->payment_method),
                'Reference' => $contribution->reference_number
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Member Name',
            'Amount',
            'Contribution Date',
            'Payment Method',
            'Reference Number'
        ];
    }
}