<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PessoaEnderecoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'pes_id' => 'required|exists:pessoa,pes_id', 
            'end_id' => 'required|exists:endereco,end_id',
        ];
    }

    public function messages(): array
    {
        return [
            'pes_id.required' => 'O ID da pessoa é obrigatório.',
            'pes_id.exists' => 'A pessoa selecionada não existe.',
            'end_id.required' => 'O ID do endereço é obrigatório.',
            'end_id.exists' => 'O endereço selecionado não existe.',
        ];
    }
}
