<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping};
use App\Models\Contribution;

class ContributionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->get();
    }

    public function headings(): array
    {
        return [
            'Member Name',
            'Amount',
            'Payment Method',
            'Date',
            'Status',
            'Transaction ID'
        ];
    }

    public function map($contribution): array
    {
        return [
            $contribution->member->user->name,
            number_format($contribution->amount, 2),
            ucfirst($contribution->payment_method),
            $contribution->created_at->format('Y-m-d H:i:s'),
            ucfirst($contribution->status),
            $contribution->transaction_id
        ];
    }
}