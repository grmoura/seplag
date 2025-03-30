<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServidorTemporarioRequest;
use App\Models\ServidorTemporario;
use Illuminate\Http\Response;

class ServidorTemporarioController extends Controller
{
    public function index()
    {
        $servidoresTemporarios = ServidorTemporario::paginate(3);

        return response()->json([
            'message' => 'Servidores Temporarios carregados com sucesso!',
            'servidores_temporarios' => $servidoresTemporarios
        ]);
    }

    public function store(ServidorTemporarioRequest $servidorTemporarioRequest)
    {
        $servidorTemporario = ServidorTemporario::create($servidorTemporarioRequest->all());
        return response()->json([
            'message' => 'Servidor Temporario cadastrado com sucesso!',
            'servidor_temporario' => $servidorTemporario
        ], Response::HTTP_CREATED);
    }

    public function show($pes_id)
    {
        $servidorTemporario = ServidorTemporario::where('pes_id', $pes_id)->first();

        if (!$servidorTemporario)
            return response()->json(['message' => 'Servidor Temporario não encontrado.'], Response::HTTP_NOT_FOUND);

        return response()->json([
            'message' => 'Servidor Temporario carregado com sucesso!',
            'servidor_temporario' => $servidorTemporario
        ]);
    }

    public function update(ServidorTemporarioRequest $servidorTemporarioRequest, $pes_id)
    {
        $validated = $servidorTemporarioRequest->validated();

        $servidorTemporario = ServidorTemporario::where('pes_id', $pes_id)->first();

        if (!$servidorTemporario)
            return response()->json(['message' => 'Servidor Temporario não encontrado.'], Response::HTTP_NOT_FOUND);

        $servidorTemporario->update(['st_data_admissao' => $validated['st_data_admissao'], 'st_data_demissao' => $validated['st_data_demissao']]);

        return response()->json([
            'message' => 'Servidor Temporario atualizado com sucesso!',
            'servidor_temporario' => $servidorTemporario
        ]);
    }

    public function destroy($pes_id)
    {
        $deleted = ServidorTemporario::where('pes_id', $pes_id)->delete();

        if ($deleted === 0) 
            return response()->json(['message' => 'Servidor Temporario não encontrado.'], Response::HTTP_NOT_FOUND);

        return response()->json(['message' => 'Servidor Temporario deletado com sucesso!'], Response::HTTP_OK);
    }
}
