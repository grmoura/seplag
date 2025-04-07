<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServidorEfetivoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules =   [
            'se_matricula' => 'required|string|max:20',
            'pes_nome' => 'required|string|max:200',
            'pes_data_nascimento' => 'required|date',
            'pes_sexo' => 'required|string|max:9',
            'pes_mae' => 'required|string|max:200',
            'pes_pai' => 'required|string|max:200',
            'end_tipo_logradouro' => 'required|string|max:50',
            'end_logradouro' => 'required|string|max:200',
            'end_numero' => 'required|nullable|integer',
            'end_bairro' => 'required|nullable|string|max:100',
            'cid_nome' => 'required|string|max:200',
            'cid_uf' => 'required|string|max:2',
            'unid_id' => 'required|exists:unidade,unid_id',
            'lot_data_lotacao' => 'required|date',
            'lot_data_remocao' => 'nullable|date|after_or_equal:lot_data_lotacao',
            'lot_portaria' => 'required|string|max:100',
        ];

        if ($this->isMethod('post')) 
            $rules['fotos'] = ['required', 'array', 'max:5'];
        
        return $rules;
    }

    public function messages(): array
    {
        return [
            'fotos.required' => 'O campo :attribute é obrigatório.',
            'se_matricula.required' => 'A :attribute é obrigatória.',
            'se_matricula.string' => 'A :attribute deve ser um texto válido.',
            'se_matricula.max' => 'A :attribute não pode ter mais de 20 caracteres.',
            //'se_matricula.unique' => 'Esta :attribute já está cadastrada.',
            'pes_nome.required' => 'O :attribute é obrigatório.',
            'pes_nome.string' => 'O :attribute deve ser um texto válido.',
            'pes_nome.max' => 'O :attribute não pode ter mais de 200 caracteres.',
            'pes_data_nascimento.date' => 'A :attribute deve ser uma data válida.',
            'pes_data_nascimento.required' => 'O :attribute é obrigatório.',
            'pes_sexo.required' => 'O :attribute é obrigatório.',
            'pes_sexo.string' => 'O :attribute deve ser um texto válido.',
            'pes_sexo.max' => 'O :attribute não pode ter mais de 9 caracteres.',
            'pes_mae.required' => 'O :attribute é obrigatório.',
            'pes_mae.string' => 'O :attribute deve ser um texto válido.',
            'pes_mae.max' => 'O :attribute não pode ter mais de 200 caracteres.',
            'pes_pai.required' => 'O :attribute é obrigatório.',
            'pes_pai.string' => 'O :attribute deve ser um texto válido.',
            'pes_pai.max' => 'O :attribute não pode ter mais de 200 caracteres.',
            'fotos.max' => 'O :attribute não pode ter mais de 5 arquivos.',
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
