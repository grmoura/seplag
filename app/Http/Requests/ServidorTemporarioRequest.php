<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServidorTemporarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pes_id' => 'required|exists:pessoa,pes_id',
            'st_data_admissao' => 'required|date',
            'st_data_demissao' => 'nullable|date'
        ];
    }

    public function messages(): array
    {
        return [
            'pes_id.required' => 'O ID da pessoa é obrigatório.',
            'pes_id.exists' => 'O ID da pessoa deve existir na tabela de pessoa.',
            'st_data_admissao.required' => 'A :attribute é obrigatória.',
            'st_data_admissao.date' => 'A :attribute deve ser uma data válida.',
            'st_data_demissao.date' => 'A :attribute deve ser uma data válida.'
        ];
    }
}
