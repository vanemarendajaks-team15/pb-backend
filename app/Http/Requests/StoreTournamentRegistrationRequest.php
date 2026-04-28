<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\Tournament;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTournamentRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Tournament|null $tournament */
        $tournament = $this->route('tournament');

        return [
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id'),
                function (string $attribute, mixed $value, \Closure $fail) use ($tournament): void {
                    if (! $tournament instanceof Tournament) {
                        $fail('Selected tournament is invalid.');

                        return;
                    }

                    $belongsToTournament = Category::query()
                        ->whereKey($value)
                        ->where('tournament_id', $tournament->id)
                        ->exists();

                    if (! $belongsToTournament) {
                        $fail('Selected category does not belong to this tournament.');
                    }
                },
            ],
            'player1_email' => [
                'required',
                'email',
                Rule::exists('users', 'email'),
            ],
            'player2_email' => [
                'required',
                'email',
                Rule::exists('users', 'email'),
                'different:player1_email',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'player1_email.exists' => 'First player must be an existing user.',
            'player2_email.exists' => 'Second player must be an existing user.',
            'player2_email.different' => 'Players must be different users.',
        ];
    }
}
