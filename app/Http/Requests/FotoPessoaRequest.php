<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FotoPessoaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pes_id' => 'required|exists:pessoa,pes_id',
            'fp_bucket' => 'string|max:50',
            'fp_hash' => 'string|max:50',
            'fotos' => 'required|array|max:5',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120' 
        ];
    }

    public function messages()
    {
        return [
            'pes_id.required' => 'O campo :attribute é obrigatório.',
            'pes_id.exists' => 'O :attribute informado não existe na tabela pessoa.',
            'fp_bucket.string' => 'O campo :attribute deve ser uma string.',
            'fp_bucket.max' => 'O campo :attribute não pode ter mais de 50 caracteres.',
            'fp_hash.string' => 'O campo :attribute deve ser uma string.',
            'fp_hash.max' => 'O campo :attribute não pode ter mais de 50 caracteres.',
        ];
    }
}
