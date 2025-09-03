<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlunoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        return $user->hasRole('coordenador') || $user->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
           // dd($this->all()); 
            return [
                'nome' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'matricula' => 'required|integer|unique:aluno,matricula',
                //'contexto' => 'nullable|string',
            ];
        }

        if ($this->isMethod('put')) {
            return [
                'nome' => 'required|string|max:100',
                'matricula' => 'required|integer',
            ];
        }

        return [];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.string' => 'O nome deve ser um texto.',
            'nome.max' => 'O nome não pode ter mais que 100 caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email informado não é válido.',
            'email.unique' => 'O email informado já está em uso por outro usuário.',
            'matricula.required' => 'A matrícula é obrigatória.',
            'matricula.integer' => 'A matrícula deve ser um número inteiro.',
            'matricula.unique' => 'Esta matrícula já está cadastrada.',
        ];
    }
}