<?php

namespace App\Http\Controllers;

use App\Http\Requests\PessoaEnderecoRequest;
use App\Models\Endereco;
use App\Models\Pessoa;
use App\Models\PessoaEndereco;
use Illuminate\Http\Response;

class PessoaEnderecoController extends Controller
{
    public function index()
    {
        $pessoasEnderecos = PessoaEndereco::with(['pessoas', 'endereco'])->paginate(3);

        return response()->json([
            'message' => 'Vínculos de Pessoa x Endereços carregados com sucesso!',
            'pessoas_enderecos' => $pessoasEnderecos
        ]);
    }

    public function store(PessoaEnderecoRequest $pessoaEnderecoRequest)
    {
        $validated = $pessoaEnderecoRequest->validated();
        $unidadesEnderecos = PessoaEndereco::where('pes_id', $validated['pes_id'])->where('end_id', $validated['end_id'])->first();

        if ($unidadesEnderecos)
            return response()->json(['message' => 'Já existe um vinculo de Pessoa x Endereço.'], Response::HTTP_NOT_FOUND);

        $unidadesEnderecosCreate = PessoaEndereco::create(['pes_id' => $validated['pes_id'], 'end_id' => $validated['end_id']]);
        return response()->json([
            'message' => 'Pessoa x Endereço vinculados com sucesso!',
            'pessoa_endereco' => $unidadesEnderecosCreate
        ], Response::HTTP_CREATED);
    }

    public function show($pes_id, $end_id)
    {
        $pessoa = Pessoa::where('pes_id', $pes_id)->exists();

        if (!$pessoa)
            return response()->json(['message' => 'Não foi encontrado vínculo com essa Pessoa.'], Response::HTTP_NOT_FOUND);

        $endereco = Endereco::where('end_id', $end_id)->exists();

        if (!$endereco)
            return response()->json(['message' => 'Não foi encontrado vínculo com esse Endereço.'], Response::HTTP_NOT_FOUND);

        $pessoaEndereco = PessoaEndereco::where('pes_id', '=', $pes_id)->where('end_id', '=', $end_id)->get();

        return response()->json([
            'message' => 'Vínculo Pessoa x Endereço carregado com sucesso!',
            'pessoa_endereco' => $pessoaEndereco
        ]);
    }

    public function update($pes_id, $end_id, PessoaEnderecoRequest $pessoaEnderecoRequest)
    {
        $pessoaEndereco = PessoaEndereco::where('pes_id', $pes_id)->where('end_id', $end_id)->first();

        if (!$pessoaEndereco)
            return response()->json(['message' => 'Vínculo Pessoa x Endereço não encontrado'], Response::HTTP_NOT_FOUND);

        $pessoaEndereco->update($pessoaEnderecoRequest->validated());

        return response()->json([
            'message' => 'Vínculo Pessoa x Endereço atualizado com sucesso!',
            'data' => $pessoaEndereco
        ], Response::HTTP_OK);
    }

    public function destroy($pes_id, $end_id)
    {
        $deleted = PessoaEndereco::where('pes_id', $pes_id)->where('end_id', $end_id)->delete();;

        if ($deleted === 0)
            return response()->json(['message' => 'Vínculo Pessoa x Endereço não encontrado'], Response::HTTP_NOT_FOUND);

        return response()->json(['message' => 'Vínculo Pessoa x Endereço deletado com sucesso!'], Response::HTTP_OK);
    }
}
