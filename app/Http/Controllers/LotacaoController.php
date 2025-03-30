<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotacaoRequest;
use App\Models\Lotacao;
use App\Models\Pessoa;
use App\Models\Unidade;
use Illuminate\Http\Response;

class LotacaoController extends Controller
{
    public function index()
    {
        $lotacoes = Lotacao::paginate(3);

        return response()->json([
            'message' => 'Lotações carregadas com sucesso!',
            'lotacoes' => $lotacoes
        ]);
    }

    public function store(LotacaoRequest $lotacaoRequest)
    {
        $lotacao = Lotacao::create($lotacaoRequest->all());
        return response()->json([
            'message' => 'Lotação cadastrada com sucesso!',
            'lotacao' => $lotacao
        ], Response::HTTP_CREATED);
    }

    public function show($lot_id)
    {
        $lotacao = Lotacao::find($lot_id);

        if (!$lotacao)
            return response()->json(['message' => 'Lotação não encontrada.'], Response::HTTP_NOT_FOUND);

        return response()->json([
            'message' => 'Lotação carregada com sucesso!',
            'cidade' => $lotacao
        ]);
    }

    public function update(LotacaoRequest $lotacaoRequest, $lot_id)
    {
        $lotacao = Lotacao::find($lot_id);

        if (!$lotacao)
            return response()->json(['message' => 'Lotação não encontrada.'], Response::HTTP_NOT_FOUND);

        $lotacao->update($lotacaoRequest->all());

        return response()->json([
            'message' => 'Lotação atualizada com sucesso!',
            'lotacao' => $lotacao
        ]);
    }

    public function destroy($lot_id)
    {
        $lotacao = Lotacao::find($lot_id);

        if (!$lotacao)
            return response()->json(['message' => 'Lotação não encontrada.'], Response::HTTP_NOT_FOUND);

        $lotacao->delete();
        return response()->json(['message' => 'Lotação deletada com sucesso!'], Response::HTTP_OK);
    }
}
