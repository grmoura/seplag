<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServidorEfetivoComLotacaoRequest;
use App\Models\FotoPessoa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ServidorEfetivoComLotacaoController extends Controller
{
    public function listaServidoresEfetivosComLotacao(ServidorEfetivoComLotacaoRequest $servidorEfetivoComLotacaoRequest)
    {
        $validated = $servidorEfetivoComLotacaoRequest->validated();


        $unid_id = $validated['unid_id'];
        $servidoresEfetivosLotados = DB::table('servidor_efetivo')
            ->join('lotacao', 'servidor_efetivo.pes_id', '=', 'lotacao.pes_id')
            ->join('pessoa', 'servidor_efetivo.pes_id', '=', 'pessoa.pes_id')
            ->join('foto_pessoa', 'servidor_efetivo.pes_id', '=', 'foto_pessoa.pes_id')
            ->join('unidade', 'lotacao.unid_id', '=', 'unidade.unid_id')
            ->where('lotacao.unid_id', $unid_id)
            ->select(
                'pessoa.pes_nome as nome',
                DB::raw("DATE_PART('year', AGE(CURRENT_DATE, pessoa.pes_data_nascimento)) as Idade"),
                'unidade.unid_nome as unidade_lotacao',
                'foto_pessoa.fp_hash'
            )->paginate(3);


        if (!$servidoresEfetivosLotados)
            return response()->json(['message' => 'Não foi encontrado Servidor Efetivo nessa Unidade pesquisada.'], Response::HTTP_NOT_FOUND);

            $servidoresEfetivosLotados->getCollection()->transform(function ($servidor) {
                $servidor->foto = Storage::temporaryUrl(
                    $servidor->fp_hash, 
                    now()->addMinutes(5)
                );
                return $servidor;
            });

        return response()->json([
            'message' => 'Servidores Efetivos Lotados na unidade: ' . $unid_id . ' carregados com sucesso!',
            'servidores_efetivos_com_lotacao' => $servidoresEfetivosLotados
        ]);
    }
}
