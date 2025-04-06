<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MembersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Member::with('contributions')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Full Name',
            'Email',
            'Phone',
            'Total Contributions',
            'Registration Date'
        ];
    }

    public function map($member): array
    {
        return [
            $member->id,
            $member->name,
            $member->email,
            $member->phone,
            $member->contributions->sum('amount'),
            $member->created_at->format('Y-m-d')
        ];
    }
}