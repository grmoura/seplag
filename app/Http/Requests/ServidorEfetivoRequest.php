<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServidorEfetivoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pes_id' => 'required|exists:pessoa,pes_id',
            'se_matricula' => 'required|string|max:20|unique:servidor_efetivo,se_matricula',
        ];
    }

    public function messages(): array
    {
        return [
            'pes_id.required' => 'O ID da pessoa é obrigatório.',
            'pes_id.exists' => 'O ID da pessoa deve existir na tabela de pessoa.',
            'se_matricula.required' => 'A :attribute é obrigatória.',
            'se_matricula.string' => 'A :attribute deve ser um texto válido.',
            'se_matricula.max' => 'A :attribute não pode ter mais de 20 caracteres.',
            'se_matricula.unique' => 'Esta :attribute já está cadastrada.',
        ];
    }
}
