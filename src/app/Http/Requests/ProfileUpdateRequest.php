<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            
            'titulacao' => ['nullable', 'string', 'max:255'],
            'biografia' => ['nullable', 'string', 'max:5000'],

            'links' => ['nullable', 'array'],
            'links.*' => ['nullable', 'url', 'max:255'],
            'new_links.*' => ['nullable', 'string', 'max:2048', 'url'],
            'area' => ['nullable', 'string', 'max:255'],
        ];
    }

    /* mensagens de erro das validações dos campos.
    *
    * @return array<string, string>
    */
    public function messages(): array{
        return [
            'titulacao.max' => 'O campo Titulação é muito grande. O limite é 255 caracteres!',
            'biografia.max' => 'Sua biografia não pode exceder 5000 caracteres.',
            'area.max'=>'O campo de área não pode ultrapassar 255 caracteres!',
            'links.max'=>'Um link não pode exceder 255 caracteres',
            'links.*.url'  => 'O link deve ser um url. Por favor, inclua http:// ou https://',
            'new_links.*.url' => 'O link deve ser um url. Por favor, inclua http:// ou https://',
        ];
    }
}
