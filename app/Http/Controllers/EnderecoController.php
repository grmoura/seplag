<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnderecoRequest;
use App\Models\Endereco;
use App\Models\UnidadeEndereco;
use Illuminate\Http\Response;

class EnderecoController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Endereços carregados com sucesso!',
            'enderecos' => Endereco::paginate(3)
        ]);
    }

    public function store(EnderecoRequest $request)
    {
        $endereco = Endereco::create($request->validated());

        return response()->json([
            'message' => 'Endereço cadastrado com sucesso!',
            'endereco' => $endereco
        ], Response::HTTP_CREATED);
    }

    public function show($end_id)
    {
        $endereco = Endereco::find($end_id);

        if (!$endereco)
            return response()->json(['message' => 'Endereço não encontrado.'], Response::HTTP_NOT_FOUND);

        return response()->json([
            'message' => 'Endereço carregado com sucesso!',
            'endereco' => $endereco
        ]);
    }

    public function update(EnderecoRequest $request, $end_id)
    {
        $endereco = Endereco::find($end_id);

        if (!$endereco)
            return response()->json(['message' => 'Endereço não encontrado.'], Response::HTTP_NOT_FOUND);

        $endereco->update($request->validated());

        return response()->json([
            'message' => 'Endereço atualizado com sucesso!',
            'endereco' => $endereco
        ]);
    }

    public function destroy($end_id)
    {
        $endereco = Endereco::find($end_id);
        $unidadeEndereco = UnidadeEndereco::where('end_id', $end_id)->exists();

        if (!$endereco)
            return response()->json(['message' => 'Endereço não encontrado.'], Response::HTTP_NOT_FOUND);

        if ($unidadeEndereco)
            return response()->json(['message' => 'Endereço está sendo utilizada em Unidade X Endereço.'], Response::HTTP_NOT_FOUND);

        $endereco->delete();
        return response()->json(['message' => 'Endereço deletado com sucesso!']);
    }
}
