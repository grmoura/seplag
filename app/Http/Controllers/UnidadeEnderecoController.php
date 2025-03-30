<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadeEnderecoRequest;
use App\Models\Endereco;
use App\Models\Unidade;
use App\Models\UnidadeEndereco;
use Illuminate\Http\Response;

class UnidadeEnderecoController extends Controller
{
    public function index()
    {
        $unidadesEnderecos = UnidadeEndereco::with(['unidade', 'endereco'])->paginate(3);

        return response()->json([
            'message' => 'Vínculos de Unidades x Endereços carregados com sucesso!',
            'unidades_enderecos' => $unidadesEnderecos
        ]);
    }

    public function store(UnidadeEnderecoRequest $unidadeEnderecoRequest)
    {
        $validated = $unidadeEnderecoRequest->validated();
        $unidadesEnderecos = UnidadeEndereco::create(['unid_id' => $validated['unid_id'], 'end_id' => $validated['end_id']]);
        return response()->json([
            'message' => 'Unidade x Endereço vinculados com sucesso!',
            'unidades_endereco' => $unidadesEnderecos
        ], Response::HTTP_CREATED);
    }

    public function show($unid_id, $end_id)
    {
        $unidade = Unidade::where('unid_id', $unid_id)->exists();

        if (!$unidade)
            return response()->json(['message' => 'Não foi encontrado vínculo com essa Unidade.'], Response::HTTP_NOT_FOUND);

        $endereco = Endereco::where('end_id', $end_id)->exists();

        if (!$endereco)
            return response()->json(['message' => 'Não foi encontrado vínculo com essa Endereço.'], Response::HTTP_NOT_FOUND);

        $unidadesEnderecos = UnidadeEndereco::where('unid_id', '=', $unid_id)->where('end_id', '=', $end_id)->get();

        return response()->json([
            'message' => 'Vínculo Unidade x Endereço carregado com sucesso!',
            'unidades_endereco' => $unidadesEnderecos
        ]);
    }

    public function update($unid_id, $end_id, UnidadeEnderecoRequest $UnidadeEnderecoRequest)
    {
        $unidadeEndereco = UnidadeEndereco::where('unid_id', $unid_id)->where('end_id', $end_id)->first();

        if (!$unidadeEndereco)
            return response()->json(['message' => 'Vínculo Unidade x Endereço não encontrado'], Response::HTTP_NOT_FOUND);

        $unidadeEndereco->update($UnidadeEnderecoRequest->validated());

        return response()->json([
            'message' => 'Vínculo Unidade x Endereço atualizado com sucesso!',
            'data' => $unidadeEndereco
        ], Response::HTTP_OK);
    }

    public function destroy($unid_id, $end_id)
    {
        $deleted = UnidadeEndereco::where('unid_id', $unid_id)->where('end_id', $end_id)->delete();;

        if ($deleted === 0) 
            return response()->json(['message' => 'Vínculo Unidade x Endereço não encontrado'], Response::HTTP_NOT_FOUND);

        return response()->json(['message' => 'Vínculo Unidade x Endereço deletado com sucesso!'], Response::HTTP_OK);
    }
}
