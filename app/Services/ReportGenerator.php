<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Event;
use App\Models\Resource;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ReportGenerator
{
    protected $jumuiya;
    protected $startDate;
    protected $endDate;

    public function __construct($jumuiya, $startDate = null, $endDate = null)
    {
        $this->jumuiya = $jumuiya;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function generate(string $type): Collection
    {
        return match($type) {
            'members' => $this->generateMembersReport(),
            'events' => $this->generateEventsReport(),
            'resources' => $this->generateResourcesReport(),
            default => collect([]),
        };
    }

    protected function generateMembersReport(): Collection
    {
        $query = Member::query()
            ->where('jumuiya_id', $this->jumuiya->id)
            ->with('user');
        
        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }
        
        return $query->get()->map(function ($member) {
            return [
                'Name' => $member->name,
                'Email' => $member->user->email,
                'Phone' => $member->user->phone,
                'Status' => ucfirst($member->status),
                'Joined Date' => $member->created_at->format('d/m/Y')
            ];
        });
    }

    protected function generateEventsReport(): Collection
    {
        $query = Event::query()
            ->where('jumuiya_id', $this->jumuiya->id)
            ->with('attendees');
        
        if ($this->startDate) {
            $query->whereDate('start_time', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('start_time', '<=', $this->endDate);
        }
        
        return $query->get()->map(function ($event) {
            return [
                'Name' => $event->name,
                'Description' => Str::limit($event->description, 100),
                'Start Time' => $event->start_time->format('d/m/Y H:i'),
                'End Time' => $event->end_time->format('d/m/Y H:i'),
                'Location' => $event->location,
                'Attendees' => $event->attendees->count()
            ];
        });
    }

    protected function generateResourcesReport(): Collection
    {
        $query = Resource::query()
            ->where('jumuiya_id', $this->jumuiya->id);
        
        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }
        
        return $query->get()->map(function ($resource) {
            return [
                'Title' => $resource->title,
                'Type' => ucfirst($resource->type),
                'Size' => number_format($resource->size / 1024, 2) . ' KB',
                'Downloads' => $resource->download_count ?? 0,
                'Created At' => $resource->created_at->format('d/m/Y')
            ];
        });
    }
}
