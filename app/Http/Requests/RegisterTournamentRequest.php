<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterTournamentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'data' => ['required', 'array'],
            'data.name' => ['required', 'string', 'max:255'],
            'data.location' => ['required', 'string', 'max:255'],
            'data.startDate' => ['required', 'date'],
            'data.endDate' => ['required', 'date', 'after:data.startDate'],
            'data.posterReference' => ['required', 'string', 'max:255'],
            'data.description' => ['required', 'string'],
            'data.directorId' => [
                'required',
                'integer',
                Rule::exists('users', 'id'),
            ],
        ];
    }
}
