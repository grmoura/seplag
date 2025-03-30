<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LotacaoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pes_id' => 'required|exists:pessoa,pes_id',
            'unid_id' => 'required|exists:unidade,unid_id',
            'lot_data_lotacao' => 'required|date',
            'lot_data_remocao' => 'nullable|date|after_or_equal:lot_data_lotacao',
            'lot_portaria' => 'required|string|max:100',
        ];
    }

    public function messages()
    {
        return [
            'pes_id.required' => 'O campo :attribute é obrigatório.',
            'pes_id.exists' => 'O :attribute informado não existe na tabela pessoa.',
            'unid_id.required' => 'O campo :attribute é obrigatório.',
            'unid_id.exists' => 'O :attribute informado não existe na tabela unidade.',
            'lot_data_lotacao.required' => 'A :attribute é obrigatória.',
            'lot_data_lotacao.date' => 'A :attribute deve ser uma data válida.',
            'lot_data_remocao.date' => 'A :attribute deve ser uma data válida.',
            'lot_data_remocao.after_or_equal' => 'A :attribute deve ser posterior ou igual à :attribute.',
            'lot_portaria.required' => 'O campo :attribute é obrigatório.',
            'lot_portaria.string' => 'O campo :attribute deve ser uma string.',
            'lot_portaria.max' => 'O campo :attribute não pode ter mais de 200 caracteres.',
        ];
    }
}
