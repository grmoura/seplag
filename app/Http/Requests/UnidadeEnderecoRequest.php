<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadeEnderecoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'unid_id' => 'required|exists:unidade,unid_id', 
            'end_id' => 'required|exists:endereco,end_id',
        ];
    }

    public function messages(): array
    {
        return [
            'unid_id.required' => 'O ID da unidade é obrigatório.',
            'unid_id.exists' => 'A unidade selecionada não existe.',
            'end_id.required' => 'O ID do endereço é obrigatório.',
            'end_id.exists' => 'O endereço selecionado não existe.',
        ];
    }
}
