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
            'end_tipo_logradouro' => 'required|string|max:50',
            'end_logradouro' => 'required|string|max:200',
            'end_numero' => 'required|nullable|integer',
            'end_bairro' => 'required|nullable|string|max:100',
            'cid_nome' => 'required|string|max:200',
            'cid_uf' => 'required|string|max:2',
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
            'end_tipo_logradouro.required' => 'O tipo de :attribute é obrigatório.',
            'end_tipo_logradouro.string' => 'O tipo de :attribute deve ser um texto.',
            'end_tipo_logradouro.max' => 'O tipo de :attribute não pode ter mais de 50 caracteres.',
            'end_logradouro.required' => 'O :attribute é obrigatório.',
            'end_logradouro.string' => 'O :attribute deve ser um texto.',
            'end_logradouro.max' => 'O :attribute não pode ter mais de 200 caracteres.',
            'end_numero.integer' => 'O :attribute deve ser um valor inteiro.',
            'end_numero.required' => 'O :attribute é obrigatório.',
            'end_bairro.required' => 'O :attribute é obrigatório.',
            'end_bairro.string' => 'O :attribute deve ser um texto.',
            'end_bairro.max' => 'O :attribute não pode ter mais de 100 caracteres.',
            'cid_nome.required' => 'O nome da :attribute é obrigatório.',
            'cid_nome.string' => 'O nome da :attribute deve ser uma string.',
            'cid_nome.max' => 'O nome da :attribute não pode ter mais de 200 caracteres.',
            'cid_uf.required' => 'O :attribute é obrigatório.',
            'cid_uf.string' => 'O :attribute deve ser uma string.',
            'cid_uf.max' => 'O :attribute deve ter no máximo 2 caracteres.',
        ];
    }
}
