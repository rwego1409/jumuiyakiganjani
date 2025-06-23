<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Member;

class MembersExport implements FromCollection, WithHeadings
{
    private $dateRange;
    private $jumuiyaIds;

    public function __construct($dateRange, $jumuiyaIds = null)
    {
        $this->dateRange = $dateRange;
        $this->jumuiyaIds = $jumuiyaIds;
    }

    public function collection()
    {
        $query = Member::with(['user', 'jumuiya'])
            ->whereBetween('created_at', [
                $this->dateRange['start_date'],
                $this->dateRange['end_date']
            ]);
        if ($this->jumuiyaIds) {
            $query->whereIn('jumuiya_id', (array)$this->jumuiyaIds);
        }
        return $query->get()
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
