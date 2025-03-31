<?php

namespace App\Http\Controllers;

use App\Http\Requests\FotoPessoaRequest;
use App\Models\FotoPessoa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FotoPessoaController extends Controller
{
    public function index()
    {
        $fotoPessoa = FotoPessoa::paginate(3);

        return response()->json([
            'message' => 'Cidades carregadas com sucesso!',
            'fotos_pessoas' => $fotoPessoa
        ]);
    }

    public function store(FotoPessoaRequest $fotoPessoaRequest)
    {
        $files = Storage::disk('s3')->files();

        // $validated = $fotoPessoaRequest->validated();
        // if (!$fotoPessoaRequest->hasFile('foto'))
        //     return response()->json(['message' => 'Selecione um arquivo para enviar como foto.'], Response::HTTP_BAD_REQUEST);

        // if ($fotoPessoaRequest->hasFile('foto')) {
        //     $file = $fotoPessoaRequest->file('foto');

            // $content = "Este é o conteúdo do meu arquivo de texto.\nAqui está outra linha.";

        //     // Definindo o nome do arquivo
            // $fileName = 'meuarquivo.txt';;

        //     // Armazenando o arquivo no S3
            // Storage::disk('s3')->put($fileName, $content);

        //     // $fotoPessoa = FotoPessoa::create([
        //     //     'pes_id' => $validated['pes_id'],
        //     //     'fp_data' => $validated['fp_data'],
        //     //     'fp_bucket' => 'minio',
        //     //     'fp_hash' => $path,
        //     // ]);

        //     // return response()->json([
        //     //     'message' => 'Foto Pessoa armazenada com sucesso!',
        //     //     'foto_pessoa' => $fotoPessoa
        //     // ], Response::HTTP_CREATED);
        // }

        // return response()->json(['message' => 'Arquivo de foto não enviado.'], Response::HTTP_BAD_REQUEST);
    }

    public function show($cid_id)
    {
        $cidade = FotoPessoa::find($cid_id);

        if (!$cidade)
            return response()->json(['message' => 'Cidade não encontrada.'], Response::HTTP_NOT_FOUND);

        return response()->json([
            'message' => 'Cidade carregada com sucesso!',
            'cidade' => $cidade
        ]);
    }

    public function update(CidadeRequest $cidadeRequest, $cid_id)
    {
        $cidade = FotoPessoa::find($cid_id);

        if (!$cidade)
            return response()->json(['message' => 'Cidade não encontrada.'], Response::HTTP_NOT_FOUND);

        $cidade->update($cidadeRequest->all());

        return response()->json([
            'message' => 'Cidade atualizada com sucesso!',
            'cidade' => $cidade
        ]);
    }

    public function destroy($fp_id)
    {
        $fotoPessoa = FotoPessoa::find($fp_id);

        if (!$fotoPessoa)
            return response()->json(['message' => 'Cidade não encontrada.'], Response::HTTP_NOT_FOUND);

        $cidade->delete();
        return response()->json(['message' => 'Cidade deletada com sucesso!'], Response::HTTP_OK);
    }
}
