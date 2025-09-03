<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IntencaoMatriculaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $uniqueRule = 'unique:intencao_matricula,numero_periodo,' . ($this->intencao_matricula ? $this->intencao_matricula->id : 'NULL') . ',id,ano,' . $this->ano;

        return [
            'numero_periodo' => ['required', 'integer', 'min:1', 'max:2', $uniqueRule],
            'ano' => ['required', 'integer', 'min:2020', 'max:' . (date('Y') + 5)],
            'disciplinas' => ['array'],
            'disciplinas.*' => ['exists:disciplina,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'numero_periodo.required' => 'O número do período é obrigatório',
            'numero_periodo.integer' => 'O número do período deve ser um número inteiro',
            'numero_periodo.min' => 'O número do período deve ser no mínimo 1',
            'numero_periodo.max' => 'O número do período deve ser no máximo 2',
            'numero_periodo.unique' => 'Já existe uma intenção de matrícula para este período e ano',
            'ano.required' => 'O ano é obrigatório',
            'ano.integer' => 'O ano deve ser um número inteiro',
            'ano.min' => 'O ano deve ser no mínimo 2020',
            'ano.max' => 'O ano deve ser no máximo ' . (date('Y') + 5),
            'disciplinas.*.exists' => 'Uma ou mais disciplinas selecionadas não existem',
        ];
    }
}