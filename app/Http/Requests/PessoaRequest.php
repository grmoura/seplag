<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PessoaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pes_nome' => 'required|string|max:200',
            'pes_data_nascimento' => 'required|date',
            'pes_sexo' => 'required|string|max:9',
            'pes_mae' => 'required|string|max:200',
            'pes_pai' => 'required|string|max:200',
        ];
    }

    public function messages(): array
    {
        return [
            'pes_nome.required' => 'O :attribute é obrigatório.',
            'pes_nome.string' => 'O :attribute deve ser um texto válido.',
            'pes_nome.max' => 'O :attribute não pode ter mais de 200 caracteres.',
            'pes_data_nascimento.date' => 'A :attribute deve ser uma data válida.',
            'pes_sexo.string' => 'O :attribute deve ser um texto válido.',
            'pes_sexo.max' => 'O :attribute não pode ter mais de 9 caracteres.',
            'pes_mae.string' => 'O :attribute deve ser um texto válido.',
            'pes_mae.max' => 'O :attribute não pode ter mais de 200 caracteres.',
            'pes_pai.string' => 'O :attribute deve ser um texto válido.',
            'pes_pai.max' => 'O :attribute não pode ter mais de 200 caracteres.',
        ];
    }
}
