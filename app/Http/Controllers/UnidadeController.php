<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadeRequest;
use App\Models\Lotacao;
use App\Models\Unidade;
use App\Models\UnidadeEndereco;
use Illuminate\Http\Response;

class UnidadeController extends Controller
{
    public function index()
    {
        $unidades = Unidade::paginate(3);

        return response()->json([
            'message' => 'Unidades carregadas com sucesso!',
            'cidades' => $unidades
        ]);
    }

    public function store(UnidadeRequest $unidadeRequest)
    {
        $unidade = Unidade::create($unidadeRequest->all());
        return response()->json([
            'message' => 'Unidade cadastrada com sucesso!',
            'unidade' => $unidade
        ], Response::HTTP_CREATED);
    }

    public function show($cid_id)
    {
        $unidade = Unidade::find($cid_id);

        if (!$unidade)
            return response()->json(['message' => 'Unidade não encontrada.'], Response::HTTP_NOT_FOUND);

        return response()->json([
            'message' => 'Unidade carregada com sucesso!',
            'unidade' => $unidade
        ]);
    }

    public function update(UnidadeRequest $unidadeRequest, $cid_id)
    {
        $unidade = Unidade::find($cid_id);

        if (!$unidade)
            return response()->json(['message' => 'Unidade não encontrada.'], Response::HTTP_NOT_FOUND);

        $unidade->update($unidadeRequest->all());

        return response()->json([
            'message' => 'Unidade atualizada com sucesso!',
            'unidade' => $unidade
        ]);
    }

    public function destroy($unid_id)
    {
        $unidade = Unidade::find($unid_id);
        $unidadeEndereco = UnidadeEndereco::where('unid_id', $unid_id)->exists();
        $lotacao = Lotacao::where('unid_id', $unid_id)->exists();

        if ($lotacao)
            return response()->json(['message' => 'Unidade está vínculado em Lotação.'], Response::HTTP_NOT_FOUND);

        if ($unidadeEndereco)
            return response()->json(['message' => 'Unidade está vínculada em Unidade X Endereço.'], Response::HTTP_NOT_FOUND);

        if (!$unidade)
            return response()->json(['message' => 'Unidade não encontrada.'], Response::HTTP_NOT_FOUND);

        $unidade->delete();
        return response()->json(['message' => 'Unidade deletada com sucesso!'], Response::HTTP_OK);
    }
}
