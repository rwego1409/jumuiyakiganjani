<?php


namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Jumuiya;
use App\Models\Member;
use App\Models\Contribution;
use App\Models\Event;

class Dashboard extends Component
{
    public $jumuiyas;
    public $members;
    public $contributions;
    public $upcomingEvents;
    public $recentActivities = [];

    public function mount()
    {
        $this->jumuiyas = Jumuiya::count();
        $this->members = Member::count();
        $this->contributions = Contribution::sum('amount');
        $this->upcomingEvents = Event::where('status', 'upcoming')->count();
        
        $this->recentActivities = [
            [
                'title' => 'New Jumuiya Added',
                'description' => 'Jumuiya ya St. Peter was added to the system',
                'time' => '2 hours ago',
                'icon' => 'users',
                'color' => 'blue'
            ],
            // Add more activities as needed
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.admin');
    }
}

