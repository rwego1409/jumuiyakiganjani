<?php

namespace App\Livewire\Admin\Contributions;

use App\Models\Member;
use App\Models\Jumuiya;
use App\Models\Contribution;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public $members = [];
    public $jumuiyas = [];
    public $form = [
        'member_id' => '',
        'jumuiya_id' => '',
        'amount' => '',
        'contribution_date' => '',
        'payment_method' => 'mobile',
        'purpose' => '',
        'status' => 'pending'
    ];

    public function mount()
    {
        $this->jumuiyas = Jumuiya::where('chairperson_id', auth()->id())->get();
        $this->form['contribution_date'] = now()->format('Y-m-d');
    }

    public function updatedFormJumuiyaId($value)
    {
        if ($value) {
            $this->members = Member::where('jumuiya_id', $value)
                ->with('user')
                ->where('status', 'active')
                ->get();
        } else {
            $this->members = [];
        }
    }

    public function rules()
    {
        return [
            'form.member_id' => 'required|exists:members,id',
            'form.jumuiya_id' => 'required|exists:jumuiyas,id',
            'form.amount' => 'required|numeric|min:1000|max:1000000000',
            'form.contribution_date' => 'required|date|before_or_equal:today',
            'form.payment_method' => 'required|in:cash,mobile,bank',
            'form.purpose' => 'nullable|string|max:255',
            'form.status' => 'required|in:pending,confirmed,rejected'
        ];
    }

    public function save()
    {
        $this->validate();
        
        try {
            DB::beginTransaction();
            
            $member = Member::findOrFail($this->form['member_id']);
            
            $contribution = Contribution::create([
                'user_id' => $member->user_id,
                'recorded_by' => auth()->id(),
                'member_id' => $this->form['member_id'],
                'jumuiya_id' => $this->form['jumuiya_id'],
                'amount' => $this->form['amount'],
                'contribution_date' => $this->form['contribution_date'],
                'payment_method' => $this->form['payment_method'],
                'purpose' => $this->form['purpose'],
                'status' => $this->form['status'],
                'receipt_number' => 'RCPT-' . time() . '-' . strtoupper(Str::random(6)),
                'payment_reference' => Str::uuid()
            ]);

            DB::commit();

            $this->dispatch('contribution-created', contribution: $contribution);
            $this->reset('form');
            session()->flash('success', 'Contribution created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error creating contribution: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.contributions.create');
    }
}
