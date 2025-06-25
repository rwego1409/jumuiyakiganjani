<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping};

class EventsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->with(['attendees', 'organizer'])->get();
    }

    public function headings(): array
    {
        return [
            'Event Title',
            'Date',
            'Location',
            'Organizer',
            'Attendees Count',
            'Status',
            'Description'
        ];
    }

    public function map($event): array
    {
        return [
            $event->title,
            $event->start_time ? $event->start_time->format('Y-m-d H:i:s') : '',
            $event->location,
            $event->organizer ? $event->organizer->name : '',
            $event->attendees ? $event->attendees->count() : 0,
            $event->status,
            $event->description
        ];
    }
}
