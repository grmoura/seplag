<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CidadeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cid_nome' => 'required|string|max:200',
            'cid_uf' => 'required|string|max:2',
        ];
    }

    public function messages(): array
    {
        return [
            'cid_nome.required' => 'O nome da :attribute é obrigatório.',
            'cid_nome.string' => 'O nome da :attribute deve ser uma string.',
            'cid_nome.max' => 'O nome da :attribute não pode ter mais de 200 caracteres.',
            'cid_uf.required' => 'O :attribute é obrigatório.',
            'cid_uf.string' => 'O :attribute deve ser uma string.',
            'cid_uf.max' => 'O :attribute deve ter no máximo 2 caracteres.',
        ];
    }
}
