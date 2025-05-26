<?php

namespace App\Livewire\Admin\Contributions;

use App\Models\Contribution;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $filters = [
        'status' => '',
        'payment_method' => '',
        'date_from' => '',
        'date_to' => '',
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function render()
    {
        $jumuiyaIds = auth()->user()->jumuiyas->pluck('id');
        
        $query = Contribution::query()
            ->whereIn('jumuiya_id', $jumuiyaIds)
            ->with(['member.user', 'jumuiya']);

        if ($this->search) {
            $query->whereHas('member.user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filters['status']) {
            $query->where('status', $this->filters['status']);
        }

        if ($this->filters['payment_method']) {
            $query->where('payment_method', $this->filters['payment_method']);
        }

        if ($this->filters['date_from']) {
            $query->whereDate('contribution_date', '>=', $this->filters['date_from']);
        }

        if ($this->filters['date_to']) {
            $query->whereDate('contribution_date', '<=', $this->filters['date_to']);
        }

        $contributions = $query
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.contributions.table', [
            'contributions' => $contributions
        ]);
    }
}
