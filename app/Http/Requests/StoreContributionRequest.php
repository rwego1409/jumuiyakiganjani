<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContributionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jumuiya_id' => 'required|exists:jumuiyas,id',
            'amount' => 'required|numeric|min:1000|max:3000000',
            'contribution_date' => 'required|date',
            'phone' => ['required', 'regex:/^255\d{9}$/'], // ZenoPay expects 12 digits starting with 255
        ];
    }
}
