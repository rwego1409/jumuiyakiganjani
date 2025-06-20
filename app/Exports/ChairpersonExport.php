<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ChairpersonExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $chairperson;
    protected $startDate;
    protected $endDate;
    protected $type;

    public function __construct($chairperson, $startDate = null, $endDate = null, $type = 'all')
    {
        $this->chairperson = $chairperson;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->type = $type;
    }

    public function collection()
    {
        $jumuiya = $this->chairperson->jumuiyas()->first();
        
        switch ($this->type) {
            case 'members':
                return $jumuiya->members()
                    ->with(['user'])
                    ->when($this->startDate, function ($query) {
                        $query->whereDate('created_at', '>=', $this->startDate);
                    })
                    ->when($this->endDate, function ($query) {
                        $query->whereDate('created_at', '<=', $this->endDate);
                    })
                    ->get();

            case 'contributions':
                return $jumuiya->members()
                    ->with(['contributions.contributionType'])
                    ->get()
                    ->flatMap(function ($member) {
                        return $member->contributions
                            ->when($this->startDate, function ($collection) {
                                return $collection->where('created_at', '>=', $this->startDate);
                            })
                            ->when($this->endDate, function ($collection) {
                                return $collection->where('created_at', '<=', $this->endDate);
                            });
                    });

            case 'events':
                return $jumuiya->events()
                    ->with(['attendees'])
                    ->when($this->startDate, function ($query) {
                        $query->whereDate('start_time', '>=', $this->startDate);
                    })
                    ->when($this->endDate, function ($query) {
                        $query->whereDate('start_time', '<=', $this->endDate);
                    })
                    ->get();

            default:
                return collect([]);
        }
    }

    public function headings(): array
    {
        switch ($this->type) {
            case 'members':
                return [
                    'Name',
                    'Email',
                    'Phone',
                    'Status',
                    'Joined Date'
                ];

            case 'contributions':
                return [
                    'Member Name',
                    'Contribution Type',
                    'Amount',
                    'Status',
                    'Date'
                ];

            case 'events':
                return [
                    'Event Name',
                    'Description',
                    'Start Time',
                    'End Time',
                    'Location',
                    'Attendees Count'
                ];

            default:
                return [];
        }
    }

    public function map($row): array
    {
        switch ($this->type) {
            case 'members':
                return [
                    $row->name,
                    $row->user->email,
                    $row->user->phone,
                    ucfirst($row->status),
                    $row->created_at->format('M d, Y')
                ];

            case 'contributions':
                return [
                    $row->member->name,
                    $row->contributionType->name,
                    number_format($row->amount, 2),
                    ucfirst($row->status),
                    $row->created_at->format('M d, Y')
                ];

            case 'events':
                return [
                    $row->name,
                    $row->description,
                    $row->start_time->format('M d, Y h:i A'),
                    $row->end_time->format('M d, Y h:i A'),
                    $row->location,
                    $row->attendees->count()
                ];

            default:
                return [];
        }
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
