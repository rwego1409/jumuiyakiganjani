<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'jumuiya_id' => 'required|exists:jumuiyas,id',
            'status' => 'required|in:active,inactive',
            'joined_date' => 'required|date'
        ];
    }
}