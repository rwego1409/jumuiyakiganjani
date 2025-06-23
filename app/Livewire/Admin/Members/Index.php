<?php

namespace App\Livewire\Admin\Members;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Member;
use App\Models\Jumuiya;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $jumuiyaFilter = '';
    public $statusFilter = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    
    public $showModal = false;
    public $showDeleteModal = false;
    public $editMode = false;
    public $selectedMemberId;
    
    public $form = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'jumuiya_id' => '',
        'status' => 'active',
        'joined_date' => '',
    ];

    protected $rules = [
        'form.name' => 'required|string|max:255',
        'form.email' => 'required|email|unique:users,email',
        'form.phone' => 'required|string|max:20',
        'form.jumuiya_id' => 'required|exists:jumuiyas,id',
        'form.status' => 'required|in:active,inactive',
        'form.joined_date' => 'required|date',
    ];

    public function mount()
    {
        $this->jumuiyas = Jumuiya::all();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function createMember()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function editMember($id)
    {
        $member = Member::findOrFail($id);
        $this->form = [
            'name' => $member->user->name,
            'email' => $member->user->email,
            'phone' => $member->phone,
            'jumuiya_id' => $member->jumuiya_id,
            'status' => $member->status,
            'joined_date' => $member->joined_date->format('Y-m-d'),
        ];
        $this->selectedMemberId = $id;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $member = Member::findOrFail($this->selectedMemberId);
            $member->update([
                'phone' => $this->form['phone'],
                'jumuiya_id' => $this->form['jumuiya_id'],
                'status' => $this->form['status'],
                'joined_date' => $this->form['joined_date'],
            ]);
            
            $member->user->update([
                'name' => $this->form['name'],
                'email' => $this->form['email'],
            ]);
        } else {
            $user = User::create([
                'name' => $this->form['name'],
                'email' => $this->form['email'],
                'password' => bcrypt('password'), // Temporary password
                'role' => 'member',
            ]);

            Member::create([
                'user_id' => $user->id,
                'jumuiya_id' => $this->form['jumuiya_id'],
                'phone' => $this->form['phone'],
                'status' => $this->form['status'],
                'joined_date' => $this->form['joined_date'],
            ]);
        }

        $this->showModal = false;
        $this->dispatchBrowserEvent('notify', ['message' => 'Member saved successfully!']);
    }

    public function confirmDelete($id)
    {
        $this->selectedMemberId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteMember()
    {
        Member::findOrFail($this->selectedMemberId)->delete();
        $this->showDeleteModal = false;
        $this->dispatchBrowserEvent('notify', ['message' => 'Member deleted successfully!']);
    }

    public function resetForm()
    {
        $this->form = [
            'name' => '',
            'email' => '',
            'phone' => '',
            'jumuiya_id' => '',
            'status' => 'active',
            'joined_date' => '',
        ];
        $this->resetErrorBag();
    }

    public function render()
    {
        $members = Member::query()
            ->with(['user', 'jumuiya'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->jumuiyaFilter, function ($query) {
                $query->where('jumuiya_id', $this->jumuiyaFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.members.index', [
            'members' => $members,
            'jumuiyas' => $this->jumuiyas,
        ])->layout('layouts.admin');
    }
}
