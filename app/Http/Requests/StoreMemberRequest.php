<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Or implement your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->member->user_id ?? ''),
            'phone' => 'required|string|max:20',
            'jumuiya_id' => 'required|exists:jumuiyas,id',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other',
            'status' => 'nullable|string|in:active,inactive,pending',
            'joined_date' => 'nullable|date',
        ];
    }
}