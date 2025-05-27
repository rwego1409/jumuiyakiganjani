<?php

namespace App\Imports;

use App\Models\Contribution;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContributionsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $admin_id;

    public function __construct()
    {
        // Get first admin user's ID as fallback
        $this->admin_id = \App\Models\User::where('role', 'admin')->first()->id ?? 1;
    }

    public function model(array $row)
    {
        $member = \App\Models\Member::findOrFail($row['member_id']);
        
        return new Contribution([
            'member_id' => $row['member_id'],
            'amount' => $row['amount'],
            'created_at' => \Carbon\Carbon::parse($row['date']),
            'purpose' => $row['purpose'],
            'payment_method' => $row['payment_method'],
            'status' => $row['status'] ?? 'pending',
            'receipt_number' => $row['receipt_number'] ?? null,
            'recorded_by' => $this->admin_id,
            'jumuiya_id' => $member->jumuiya_id,
            'contribution_date' => \Carbon\Carbon::parse($row['date']),
            'user_id' => $member->user_id
        ]);
    }

    public function rules(): array
    {
        return [
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'purpose' => 'required|string',
            'payment_method' => 'required|in:cash,mpesa,bank',
            'status' => 'nullable|in:pending,paid,failed,confirmed,rejected',
            'receipt_number' => 'nullable|string'
        ];
    }
}

