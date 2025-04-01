<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultaEnderecoFuncionalController extends Controller
{
    public function consultarEnderecoFuncional(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|min:3'
        ]);
    
        $termo = $request->input('nome');
    
        $servidores = DB::table('servidor_efetivo')
            ->join('pessoa', 'servidor_efetivo.pes_id', '=', 'pessoa.pes_id')
            ->join('lotacao', 'servidor_efetivo.pes_id', '=', 'lotacao.pes_id')
            ->join('unidade', 'lotacao.unid_id', '=', 'unidade.unid_id')
            ->join('endereco', 'unidade.unid_id', '=', 'endereco.end_id')
            ->join('cidade', 'endereco.cid_id', '=', 'cidade.cid_id')
            ->where('pessoa.pes_nome', 'ILIKE', "%{$termo}%") 
            ->select(
                'pessoa.pes_nome',
                'unidade.unid_nome',
                'cidade.cid_nome',
                'cidade.cid_uf',
                'endereco.end_tipo_logradouro',
                'endereco.end_logradouro',
                'endereco.end_numero',
                'endereco.end_bairro'
            )
            ->paginate(3);
    
        if (!$servidores) 
            return response()->json(['message' => 'Nenhum servidor encontrado.'], 404);
        
    
        return response()->json([
            'message' => 'Endereços funcionais encontrados!',
            'data' => $servidores
        ]);
    }
    
}
