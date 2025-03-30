<?php

namespace App\Http\Controllers;

use App\Http\Requests\PessoaRequest;
use App\Models\Lotacao;
use App\Models\Pessoa;
use App\Models\PessoaEndereco;
use App\Models\ServidorEfetivo;
use App\Models\ServidorTemporario;
use Illuminate\Http\Response;

class PessoaController extends Controller
{
    public function index()
    {
        $pessoas = Pessoa::paginate(3);

        return response()->json([
            'message' => 'Pessoas carregadas com sucesso!',
            'pessoas' => $pessoas
        ]);
    }

    public function store(PessoaRequest $pessoaRequest)
    {
        $pessoa = Pessoa::create($pessoaRequest->all());
        return response()->json([
            'message' => 'Pessoa cadastrada com sucesso!',
            'pessoa' => $pessoa
        ], Response::HTTP_CREATED);
    }

    public function show($cid_id)
    {
        $pessoa = Pessoa::find($cid_id);

        if (!$pessoa)
            return response()->json(['message' => 'Pessoa não encontrada.'], Response::HTTP_NOT_FOUND);

        return response()->json([
            'message' => 'Pessoa carregada com sucesso!',
            'pessoa' => $pessoa
        ]);
    }

    public function update($pes_id, PessoaRequest $pessoaRequest)
    {
        $pessoa = Pessoa::find($pes_id);

        if (!$pessoa)
            return response()->json(['message' => 'Pessoa não encontrada.'], Response::HTTP_NOT_FOUND);

        $pessoa->update($pessoaRequest->all());

        return response()->json([
            'message' => 'Pessoa atualizada com sucesso!',
            'pessoa' => $pessoa
        ]);
    }

    public function destroy($pes_id)
    {
        $pessoa = Pessoa::find($pes_id);
        $servidorEfetivo = ServidorEfetivo::where('pes_id', $pes_id)->exists();
        $servidorTemporario = ServidorTemporario::where('pes_id', $pes_id)->exists();
        $pessoaEndereco = PessoaEndereco::where('pes_id', $pes_id)->exists();
        $lotacao = Lotacao::where('pes_id', $pes_id)->exists();

        if ($lotacao)
            return response()->json(['message' => 'Pessoa está vínculado em Lotação.'], Response::HTTP_NOT_FOUND);

        if ($pessoaEndereco)
            return response()->json(['message' => 'Pessoa está vínculado em Pessoa X Endereço.'], Response::HTTP_NOT_FOUND);

        if ($servidorTemporario)
            return response()->json(['message' => 'Pessoa está vínculado em  Servidor Temporario.'], Response::HTTP_NOT_FOUND);

        if ($servidorEfetivo)
            return response()->json(['message' => 'Pessoa está vínculado em  Servidor Efetivo.'], Response::HTTP_NOT_FOUND);

        if (!$pessoa)
            return response()->json(['message' => 'Pessoa não encontrada.'], Response::HTTP_NOT_FOUND);

        $pessoa->delete();
        return response()->json(['message' => 'Pessoa deletada com sucesso!'], Response::HTTP_OK);
    }
}
