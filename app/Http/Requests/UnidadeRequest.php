<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unid_nome' => 'required|string|max:200',
            'unid_sigla' => 'required|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'unid_nome.required' => 'O :attribute da unidade é obrigatório.',
            'unid_nome.string' => 'O :attribute da unidade deve ser um texto.',
            'unid_nome.max' => 'O :attribute da unidade não pode ter mais de 200 caracteres.',
            'unid_sigla.required' => 'A :attribute da unidade é obrigatória.',
            'unid_sigla.string' => 'A :attribute da unidade deve ser um texto.',
            'unid_sigla.max' => 'A :attribute da unidade não pode ter mais de 20 caracteres.',
        ];
    }
}
