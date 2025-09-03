<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisciplinaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to  make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'nome' => ['required', 'string', 'max:255'],
            'optativa' => ['sometimes', 'boolean'],
        ];

        if (!$this->has('optativa') || !$this->optativa) {
            $rules['periodo'] = ['required', 'integer', 'min:1', 'max:10'];
        } else {
            $rules['periodo'] = ['nullable', 'integer'];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da disciplina é obrigatório',
            'nome.max' => 'O nome da disciplina deve ter no máximo 255 caracteres',
            'periodo.required' => 'O período é obrigatório',
            'periodo.integer' => 'O período deve ser um número inteiro',
            'periodo.min' => 'O período deve ser no mínimo 1',
            'periodo.max' => 'O período deve ser no máximo 12',
        ];
    }
}

