<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File; // Importe a classe File
use Illuminate\Validation\Rule;

class PostagemRequest extends FormRequest
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
    $maxImageSizeKB = 60 * 1024;

    $rules = [
      'titulo' => ['required', 'max:255'],
      'texto' => ['required'],
      'tipo_postagem_id' => ['required'],
      'menu_inicial' => ['nullable'],
      'main_image' => [
        'nullable',
        File::image()
          ->max($maxImageSizeKB)
          ->dimensions(
            Rule::dimensions()->width(2700)->height(660)
          )
          ->types(['jpeg', 'png', 'gif', 'svg', 'webp']), // Tipos MIME para imagens famosas
      ],
      'imagens' => ['nullable', 'array'],
      'imagens.*' => [
        File::image()
          ->max($maxImageSizeKB)
          ->types(['jpeg', 'png', 'gif', 'svg', 'webp']),
      ],
      'arquivos' => ['nullable', 'array'],
      'arquivos.*' => [
        'file',
        'max:61440'
      ],
    ];

    return $rules;
  }

  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array<string, string>
   */
  public function messages()
  {
    return [
      'titulo.required' => 'O título é obrigatório',
      'titulo.max' => 'O tamanho máximo do título é 255 caracteres',
      'texto.required' => 'O texto é obrigatório',
      'tipo_postagem_id' => 'O tipo de postagem é obrigatório',
      'main_image.max' => 'A capa da postagem não deve exceder 60MB.',
      'main_image.image' => 'A capa da postagem deve ser um arquivo de imagem.',
      'main_image.mimes' => 'A capa da postagem deve ser do tipo: jpeg, png, gif, svg, webp.',
      'main_image.dimensions' => 'A capa da postagem deve ter a resolução de 2700x660 pixels.',
      'imagens.*.max' => 'Cada imagem não deve exceder 60MB.',
      'imagens.*.image' => 'Cada arquivo em "Imagens" deve ser um arquivo de imagem.',
      'imagens.*.mimes' => 'Cada imagem deve ser do tipo: jpeg, png, gif, svg, webp.',
      'arquivos.*.max' => 'Cada arquivo em "Arquivos" não deve exceder 60MB.',
      'arquivos.*.file' => 'Cada item em "Arquivos" deve ser um arquivo.',
    ];
  }
}
