<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadeRequest;
use App\Models\Cidade;
use App\Models\Endereco;
use App\Models\Lotacao;
use App\Models\Unidade;
use App\Models\UnidadeEndereco;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UnidadeController extends Controller
{
    public function index()
    {
        $unidades = Unidade::with([
            'enderecos.cidade'
        ])->paginate(3);

        $dados = $unidades->getCollection()->map(function ($unidade) {
            $endereco = optional($unidade->enderecos->first());
            $cidade = optional($endereco?->cidade);

            return [
                'unidade' => [
                    'unid_id' => $unidade->unid_id,
                    'unid_nome' => $unidade->unid_nome,
                    'unid_sigla' => $unidade->unid_sigla,
                ],
                'endereco' => $endereco ? [
                    'end_tipo_logradouro' => $endereco->end_tipo_logradouro,
                    'end_logradouro' => $endereco->end_logradouro,
                    'end_numero' => $endereco->end_numero,
                    'end_bairro' => $endereco->end_bairro,
                    'cidade' => $cidade ? [
                        'cid_nome' => $cidade->cid_nome,
                        'cid_uf' => $cidade->cid_uf,
                    ] : null,
                ] : null,
            ];
        });

        $unidades->setCollection($dados);

        return response()->json([
            'message' => 'Unidades carregadas com sucesso!',
            'unidades' => $unidades
        ]);
    }

    public function store(UnidadeRequest $unidadeRequest)
    {

        $validated = $unidadeRequest->validated();

        try {
            DB::beginTransaction();
            $cidade = Cidade::create(['cid_nome' => $validated['cid_nome'], 'cid_uf' => $validated['cid_uf']]);
            $unidade = Unidade::create(['unid_nome' => $validated['unid_nome'], 'unid_sigla' => $validated['unid_sigla']]);
            $endereco = Endereco::create(['end_tipo_logradouro' => $validated['end_tipo_logradouro'], 'end_logradouro' => $validated['end_logradouro'], 'end_numero' => $validated['end_numero'], 'end_bairro' => $validated['end_bairro'], 'cid_id' => $cidade->cid_id]);

            UnidadeEndereco::create(['unid_id' => $unidade->unid_id, 'end_id' => $endereco->end_id]);

            DB::commit();
            return response()->json([
                'message' => 'Unidade cadastrada com sucesso!',
                'unidade' => $unidade,
                'endereco' => $endereco,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao cadastrar Unidade.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($unid_id)
    {
        $unidade = Unidade::with('enderecos.cidade')->find($unid_id);

        if (!$unidade) {
            return response()->json([
                'message' => 'Unidade não encontrada.'
            ], Response::HTTP_NOT_FOUND);
        }

        $endereco = optional($unidade->enderecos->first());
        $cidade = optional($endereco?->cidade);

        return response()->json([
            'message' => 'Unidade carregada com sucesso!',
            'unidade' => [
                'unid_id' => $unidade->unid_id,
                'unid_nome' => $unidade->unid_nome,
                'unid_sigla' => $unidade->unid_sigla,
            ],
            'endereco' => $endereco ? [
                'end_tipo_logradouro' => $endereco->end_tipo_logradouro,
                'end_logradouro' => $endereco->end_logradouro,
                'end_numero' => $endereco->end_numero,
                'end_bairro' => $endereco->end_bairro,
                'cidade' => $cidade ? [
                    'cid_nome' => $cidade->cid_nome,
                    'cid_uf' => $cidade->cid_uf,
                ] : null,
            ] : null,
        ]);
    }

    public function update($unid_id, UnidadeRequest $request)
    {

        $unidade = Unidade::find($unid_id);

        if (!$unidade)
            return response()->json(['message' => 'Unidade não encontrada.'], Response::HTTP_NOT_FOUND);

        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $unidade = Unidade::updateOrCreate(
                ['unid_id' => $unid_id],
                [
                    'unid_nome' => $validated['unid_nome'],
                    'unid_sigla' => $validated['unid_sigla']
                ]
            );

            $cidade = Cidade::updateOrCreate(
                [
                    'cid_nome' => $validated['cid_nome'],
                    'cid_uf' => $validated['cid_uf']
                ],
                []
            );

            $unidadeEndereco = UnidadeEndereco::where('unid_id', $unid_id)->first();
            $enderecoId = $unidadeEndereco?->end_id;

            $endereco = Endereco::updateOrCreate(
                ['end_id' => $enderecoId],
                [
                    'end_tipo_logradouro' => $validated['end_tipo_logradouro'],
                    'end_logradouro' => $validated['end_logradouro'],
                    'end_numero' => $validated['end_numero'],
                    'end_bairro' => $validated['end_bairro'],
                    'cid_id' => $cidade->cid_id
                ]
            );

            UnidadeEndereco::updateOrCreate(
                ['unid_id' => $unidade->unid_id],
                ['end_id' => $endereco->end_id]
            );

            DB::commit();

            return response()->json([
                'message' => 'Unidade atualizada com sucesso!',
                'unidade' => $unidade,
                'endereco' => $endereco
            ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Erro ao atualizar Unidade.',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
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
