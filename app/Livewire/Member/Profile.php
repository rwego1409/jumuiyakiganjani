<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\Member;

class Profile extends Component
{
    public $user;
    public $member;

    protected $rules = [
        'user.name' => 'required|string|max:255',
        'user.email' => 'required|email|unique:users,email',
        'member.phone' => 'nullable|string|max:20',
        'member.address' => 'nullable|string|max:255',
        'member.birth_date' => 'nullable|date',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->member = $this->user->member ?? new Member();
    }

    public function saveProfile()
    {
        $this->validate([
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|email|unique:users,email,' . $this->user->id,
            'member.phone' => 'nullable|string|max:20',
            'member.address' => 'nullable|string|max:255',
            'member.birth_date' => 'nullable|date',
        ]);

        $this->user->save();
        $this->member->save();

        $this->dispatchBrowserEvent('notify', ['message' => 'Profile updated successfully!']);
    }

    public function render()
    {
        return view('livewire.member.profile')
            ->layout('layouts.member');
    }
}