<?php

namespace App\Http\Controllers;

use App\Http\Requests\CidadeRequest;
use App\Models\Cidade;
use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CidadeController extends Controller
{
    public function index()
    {
        $cidades = Cidade::paginate(3);

        return response()->json([
            'message' => 'Cidades carregadas com sucesso!',
            'cidades' => $cidades
        ]);
    }

    public function store(CidadeRequest $cidadeRequest)
    {
        $cidade = Cidade::create($cidadeRequest->all());
        return response()->json([
            'message' => 'Cidade cadastrada com sucesso!',
            'cidade' => $cidade
        ], Response::HTTP_CREATED);
    }

    public function show($cid_id)
    {
        $cidade = Cidade::find($cid_id);

        if (!$cidade)
            return response()->json(['message' => 'Cidade não encontrada.'], Response::HTTP_NOT_FOUND);

        return response()->json([
            'message' => 'Cidade carregada com sucesso!',
            'cidade' => $cidade
        ]);
    }
    // public function update(Request $request, $cid_id)
    // {     
       
    //     $validatedData = $request->validate([
    //         'cid_nome' => 'required|string|max:255',
    //         'cid_uf' => 'required|string|max:2',
    //     ]);
    // }
    public function update(CidadeRequest $cidadeRequest, $cid_id)
    {
        $cidade = Cidade::find($cid_id);

        if (!$cidade)
            return response()->json(['message' => 'Cidade não encontrada.'], Response::HTTP_NOT_FOUND);

        $cidade->update($cidadeRequest->all());

        return response()->json([
            'message' => 'Cidade atualizada com sucesso!',
            'cidade' => $cidade
        ]);
    }

    public function destroy($cid_id)
    {
        $cidade = Cidade::find($cid_id);
        $enderecoComCidade = Endereco::where('cid_id', $cid_id)->exists();

        if ($enderecoComCidade)
            return response()->json(['message' => 'Cidade está sendo utilizada em um endereço.'], Response::HTTP_NOT_FOUND);

        if (!$cidade)
            return response()->json(['message' => 'Cidade não encontrada.'], Response::HTTP_NOT_FOUND);

        $cidade->delete();
        return response()->json(['message' => 'Cidade deletada com sucesso!'], Response::HTTP_OK);
    }
}
