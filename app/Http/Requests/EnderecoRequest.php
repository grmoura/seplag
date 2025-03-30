<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnderecoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'end_tipo_logradouro' => 'required|string|max:50',
            'end_logradouro' => 'required|string|max:200',
            'end_numero' => 'nullable|integer',
            'end_bairro' => 'nullable|string|max:100',
            'cid_id' => 'required|exists:cidade,cid_id',
        ];
    }

    public function messages(): array
    {
        return [
            'end_tipo_logradouro.required' => 'O tipo de :attribute é obrigatório.',
            'end_tipo_logradouro.string' => 'O tipo de :attribute deve ser um texto.',
            'end_tipo_logradouro.max' => 'O tipo de :attribute não pode ter mais de 50 caracteres.',
            'end_logradouro.required' => 'O :attribute é obrigatório.',
            'end_logradouro.string' => 'O :attribute deve ser um texto.',
            'end_logradouro.max' => 'O :attribute não pode ter mais de 200 caracteres.',
            'end_numero.integer' => 'O :attribute deve ser um valor inteiro.',
            'end_bairro.string' => 'O :attribute deve ser um texto.',
            'end_bairro.max' => 'O :attribute não pode ter mais de 100 caracteres.',
            'cid_id.required' => 'A :attribute é obrigatória.',
            'cid_id.exists' => 'A :attribute informada não existe.',
        ];
    }
}
