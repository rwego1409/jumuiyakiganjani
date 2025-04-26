<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Member;

class MembersExport implements FromCollection, WithHeadings
{
    private $dateRange;

    public function __construct($dateRange)
    {
        $this->dateRange = $dateRange;
    }

    public function collection()
    {
        return Member::with(['user', 'jumuiya'])
            ->whereBetween('created_at', [
                $this->dateRange['start_date'],
                $this->dateRange['end_date']
            ])
            ->get()
            ->map(function ($member) {
                return [
                    'Name' => $member->user->name,
                    'Email' => $member->user->email,
                    'Phone' => $member->phone,
                    'Jumuiya' => $member->jumuiya->name,
                    'Joined Date' => $member->created_at->format('Y-m-d'),
                    'Status' => $member->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Jumuiya',
            'Joined Date',
            'Status'
        ];
    }
}
