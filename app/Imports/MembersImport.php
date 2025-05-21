<?php

namespace App\Imports;

use App\Models\Member;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class MembersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            Log::info('Processing row in MembersImport:', $row);
            
            // Generate a random password
            $password = Str::random(10);
            
            // Create the user
            $user = User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => Hash::make($password),
                'dob' => isset($row['dob']) ? $row['dob'] : null,
                'gender' => isset($row['gender']) ? $row['gender'] : null,
                'role' => 'member',
            ]);
            
            Log::info('Created user with ID: ' . $user->id);

            // Create the member
            $member = Member::create([
                'user_id' => $user->id,
                'jumuiya_id' => $row['jumuiya_id'],
                'phone' => $row['phone'] ?? '',
                'status' => $row['status'] ?? 'active',
                'joined_date' => $row['joined_date'] ?? now(),
            ]);
            
            Log::info('Created member with ID: ' . $member->id);
            
            // You can uncomment this to send emails when ready
            // if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            //     Mail::to($user->email)->send(new UserCredentials($user, $password));
            // }

            return $member;
        } catch (\Exception $e) {
            Log::error('Error in MembersImport: ' . $e->getMessage());
            throw $e; // Re-throw to let the Excel importer handle it
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'jumuiya_id' => 'required|exists:jumuiyas,id',
            // Make other fields optional for flexibility
            'phone' => 'nullable',
            'dob' => 'nullable|date',
            'gender' => 'nullable',
            'status' => 'nullable',
            'joined_date' => 'nullable|date',
        ];
    }
}