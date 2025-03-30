<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServidorEfetivoRequest;
use App\Models\ServidorEfetivo;
use Illuminate\Http\Response;

class ServidorEfetivoController extends Controller
{
    public function index()
    {
        $servidoresEfetivos = ServidorEfetivo::paginate(3);

        return response()->json([
            'message' => 'Servidores Efetivos carregados com sucesso!',
            'servidores_efetivos' => $servidoresEfetivos
        ]);
    }

    public function store(ServidorEfetivoRequest $servidorEfetivoRequest)
    {
        $validated = $servidorEfetivoRequest->validated();

        $servidorEfetivo = ServidorEfetivo::create(['pes_id' => $validated['pes_id'], 'se_matricula' => $validated['se_matricula']]);
        return response()->json([
            'message' => 'Servidor Efetivo cadastrada com sucesso!',
            'servidor_efetivo' => $servidorEfetivo
        ], Response::HTTP_CREATED);
    }

    public function show($cid_id)
    {
        $servidorEfetivo = ServidorEfetivo::find($cid_id);

        if (!$servidorEfetivo)
            return response()->json(['message' => 'Servidor Efetivo não encontrado.'], Response::HTTP_NOT_FOUND);

        return response()->json([
            'message' => 'Servidor Efetivo carregada com sucesso!',
            'servidor_efetivo' => $servidorEfetivo
        ]);
    }

    public function update(ServidorEfetivoRequest $servidorEfetivoRequest, $pes_id, $se_matricula)
    {
        $validated = $servidorEfetivoRequest->validated();

        $servidorEfetivo = ServidorEfetivo::where('pes_id', $pes_id)->where('se_matricula', $se_matricula)->first();

        if (!$servidorEfetivo) 
            return response()->json(['message' => 'Servidor Efetivo não encontrado.'], Response::HTTP_NOT_FOUND);
        
        $servidorEfetivo->update(['se_matricula' => $validated['se_matricula']]);

        return response()->json([
            'message' => 'Servidor Efetivo atualizado com sucesso!',
            'servidor_efetivo' => $servidorEfetivo
        ]);
    }

    public function destroy($pes_id)
    {
        $deleted = ServidorEfetivo::where('pes_id', $pes_id)->delete();

        if ($deleted === 0)
            return response()->json(['message' => 'Servidor Efetivo não encontrado.'], Response::HTTP_NOT_FOUND);

        return response()->json(['message' => 'Servidor Efetivo deletado com sucesso!'], Response::HTTP_OK);
    }
}
