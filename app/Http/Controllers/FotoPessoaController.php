<?php

namespace App\Http\Controllers;

use App\Http\Requests\FotoPessoaRequest;
use App\Models\FotoPessoa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FotoPessoaController extends Controller
{
    public function index()
    {
        $fotoPessoa = FotoPessoa::paginate(3);

        return response()->json([
            'message' => 'Fotos Pessoas carregadas com sucesso!',
            'fotos_pessoas' => $fotoPessoa
        ]);
    }

    public function show($fp_id)
    {
        $fotoPessoa = FotoPessoa::find($fp_id);

        if (!$fotoPessoa)
            return response()->json(['message' => 'Foto Pessoa não encontrada.'], Response::HTTP_NOT_FOUND);

        $fotoPessoa->foto = Storage::temporaryUrl(
            $fotoPessoa->fp_hash,
            now()->addMinutes(5)
        );

        return response()->json([
            'message' => 'Foto Pessoa carregada com sucesso!',
            'foto_pessoa' => $fotoPessoa
        ]);
    }

    public function store(FotoPessoaRequest $fotoPessoaRequest)
    {
        $validated = $fotoPessoaRequest->validated();

        if ($validated['fotos']) {

            $uploadedPhotos = FotoPessoaController::upload($validated['fotos'], $validated['pes_id']);

            return response()->json([
                'message' => 'Foto Pessoa armazenada com sucesso!',
                'foto_pessoa' => $uploadedPhotos
            ], Response::HTTP_CREATED);
        }

        return response()->json(['message' => 'Arquivo de foto não enviado.'], Response::HTTP_BAD_REQUEST);
    }

    public function update(FotoPessoaRequest $fotoPessoaRequest, $fp_id)
    {
        $validated = $fotoPessoaRequest->validated();

        $fotoPessoa = FotoPessoa::find($fp_id);

        if (!$fotoPessoa)
            return response()->json(['message' => 'Foto Pessoa não encontrada.'], Response::HTTP_NOT_FOUND);


        if ($validated['pes_id']) {
            $foto = $fotoPessoaRequest->file('fotos');

            Storage::delete($fotoPessoa->fp_hash);

            foreach ($fotoPessoaRequest->file('fotos') as $foto) {
                $hash = md5(time() . $foto->getClientOriginalName());
                $fileName = "{$validated['pes_id']}/{$hash}";
            }

            Storage::put($fileName, file_get_contents($foto));

            $fotoPessoa->fp_hash = $fileName;
            $fotoPessoa->save();

            $fotoPessoa->foto = Storage::temporaryUrl(
                $fileName,
                now()->addMinutes(5)
            );
        }

        return response()->json([
            'message' => 'Foto Pessoa atualizada com sucesso!',
            'foto_pessoa' => $fotoPessoa
        ]);
    }

    public function destroy($fp_id)
    {
        $foto = FotoPessoa::where('fp_id', $fp_id)->first();

        if (!$foto)
            return response()->json(['message' => 'Foto Pessoa não encontrada.'], Response::HTTP_NOT_FOUND);

        $caminhoArquivo = $foto->fp_hash;

        $deleted = $foto->delete();

        if ($deleted) {
            Storage::disk('s3')->delete($caminhoArquivo);
            return response()->json(['message' => 'Foto Pessoa deletada com sucesso!'], Response::HTTP_OK);
        }

        return response()->json(['message' => 'Erro ao deletar a foto.'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public static function upload($fotos, $pes_id)
    {
        $uploadedPhotos = [];

        foreach ($fotos as $foto) {
            $hash = md5(time() . $foto->getClientOriginalName());
            $fileName = "{$pes_id}/{$hash}";
            $bucket = env('AWS_BUCKET', 'pessoa-fotos');

            $put = Storage::disk('s3')->put($fileName, $foto->getContent());

            $fotoPessoa = FotoPessoa::create([
                'pes_id' => $pes_id,
                'fp_bucket' => $bucket,
                'fp_data' => now()->toDateString(),
                'fp_hash' => $fileName
            ]);

            $uploadedPhotos[] = $fotoPessoa;
        }
        return $fotoPessoa;
    }
}
