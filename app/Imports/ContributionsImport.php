<?php

namespace App\Imports;

use App\Models\Contribution;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContributionsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Contribution([
            'member_id' => $row['member_id'],  // Assuming your file has a column named 'member_id'
            'amount' => $row['amount'],  // Amount column
            'created_at' => \Carbon\Carbon::parse($row['date']),  // Date column
            'purpose' => $row['purpose'],  // Purpose column
            // Add more fields if needed
            'payment_method' => $row['payment_method'],  // Payment method column
            'status' => $row['status'] ?? 'pending',  // Default status is pending
            'receipt_number' => $row['receipt_number'] ?? null,  // Receipt number column
            'recorded_by' => auth()->id(),  // Assuming the admin is logged in
            'jumuiya_id' => $row['jumuiya_id'],  // Jumuiya ID column
            'contribution_date' => \Carbon\Carbon::parse($row['contribution_date']),  // Contribution date column
            'user_id' => $row['user_id'],  // User ID column
        ]);
    }
}

