<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Resource;

class ResourcesExport implements FromCollection, WithHeadings
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->with('jumuiya')->get()->map(function ($resource) {
            return [
                'Title' => $resource->title,
                'Type' => $resource->type,
                'Jumuiya' => $resource->jumuiya ? $resource->jumuiya->name : '',
                'Description' => $resource->description,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Title',
            'Type',
            'Jumuiya',
            'Description',
        ];
    }
}
