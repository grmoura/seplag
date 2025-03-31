<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServidorEfetivoComLotacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unid_id' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'unid_id.required' => 'O nome da :attribute é obrigatório.',
            'unid_id.numeric' => 'O :attribute deve ser uma numerico.',
        ];
    }
}
