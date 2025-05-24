<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                'string',
                'regex:/^255\d{9}$/'
            ],
            'amount' => [
                'required',
                'numeric',
                'min:1000',
                'max:3000000'
            ],
            'payment_method' => [
                'required',
                'in:mtn,airtel,tigo,vodacom'
            ],
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'nullable',
                'email',
                'max:255'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Phone number must be in format 255XXXXXXXXX',
            'amount.min' => 'Minimum contribution is 1,000 TZS',
            'amount.max' => 'Maximum contribution is 3,000,000 TZS',
            'payment_method.in' => 'Invalid payment method selected'
        ];
    }
}