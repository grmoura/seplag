<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServidorTemporarioRequest;
use App\Models\Cidade;
use App\Models\Endereco;
use App\Models\FotoPessoa;
use App\Models\Lotacao;
use App\Models\Pessoa;
use App\Models\PessoaEndereco;
use App\Models\ServidorTemporario;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ServidorTemporarioController extends Controller
{
    public function index()
    {
        $servidores = ServidorTemporario::with([
            'pessoa.enderecos.cidade',
            'pessoa.lotacoes',
        ])->paginate(3);

        $servidoreTemporarios = $servidores->map(function ($servidor) {
            $pessoa = $servidor->pessoa;
            $endereco = optional($pessoa->enderecos->first());
            $cidade = optional($endereco?->cidade);
            $lotacao = optional($pessoa->lotacoes->first());

            $fotoPessoa = FotoPessoa::where('pes_id', '=', $pessoa->pes_id)->get();

            return [
                'pessoa' => [
                    'pes_id' => $pessoa->pes_id,
                    'pes_nome' => $pessoa->pes_nome,
                    'pes_data_nascimento' => $pessoa->pes_data_nascimento,
                    'pes_sexo' => $pessoa->pes_sexo,
                    'pes_mae' => $pessoa->pes_mae,
                    'pes_pai' => $pessoa->pes_pai,
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
                'servidor_temporario' => [
                    'st_data_admissao' => $servidor->st_data_admissao,
                    'st_data_demissao' => $servidor->st_data_demissao,
                ],
                'lotacao' => $lotacao ? [
                    'unid_id' => $lotacao->unid_id,
                    'lot_data_lotacao' => $lotacao->lot_data_lotacao,
                    'lot_data_remocao' => $lotacao->lot_data_remocao,
                    'lot_portaria' => $lotacao->lot_portaria,
                ] : null,
                'foto' => $fotoPessoa
            ];
        });
        $servidores->setCollection($servidoreTemporarios);

        return response()->json([
            'message' => 'Servidores Temporarios carregados com sucesso!',
            'servidores_temporarios' => $servidores
        ]);
    }

    public function store(ServidorTemporarioRequest $servidorTemporarioRequest)
    {
        $validated = $servidorTemporarioRequest->validated();

        try {
            DB::beginTransaction();

            $pessoa = Pessoa::create(['pes_nome' => $validated['pes_nome'], 'pes_data_nascimento' => $validated['pes_data_nascimento'], 'pes_sexo' => $validated['pes_sexo'], 'pes_mae' => $validated['pes_mae'], 'pes_pai' => $validated['pes_pai']]);

            $servidorTemporario = ServidorTemporario::create(['pes_id' => $pessoa->pes_id, 'st_data_admissao' => $validated['st_data_admissao'], 'st_data_demissao' => $validated['st_data_demissao']]);

            $cidade = Cidade::create(['cid_nome' => $validated['cid_nome'], 'cid_uf' => $validated['cid_uf']]);

            $endereco = Endereco::create(['end_tipo_logradouro' => $validated['end_tipo_logradouro'], 'end_logradouro' => $validated['end_logradouro'], 'end_numero' => $validated['end_numero'], 'end_bairro' => $validated['end_bairro'], 'cid_id' => $cidade->cid_id]);

            $lotacao = Lotacao::create(['pes_id' => $pessoa->pes_id, 'unid_id' => $validated['unid_id'], 'lot_data_lotacao' => $validated['lot_data_lotacao'], 'lot_data_remocao' => $validated['lot_data_remocao'], 'lot_portaria' => $validated['lot_portaria']]);

            PessoaEndereco::create(['pes_id' => $pessoa->pes_id, 'end_id' => $endereco->end_id]);

            if ($validated['fotos'])
                $foto = FotoPessoaController::upload($validated['fotos'], $pessoa->pes_id);

            DB::commit();
            return response()->json([
                'message' => 'Servidor Temporario cadastrada com sucesso!',
                'pessoa' => $pessoa,
                'endereco' => $endereco,
                'servidor_temporario' => $servidorTemporario,
                'lotacao'  => $lotacao,
                'foto' =>  $foto
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao cadastrar Servidor Temporario.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($pes_id)
    {

        $servidor = ServidorTemporario::with([
            'pessoa.enderecos.cidade',
            'pessoa.lotacoes',
        ])->where('pes_id', $pes_id)->first();

        if (!$servidor) {
            return response()->json([
                'message' => 'Servidor Temporario não encontrado.'
            ], Response::HTTP_NOT_FOUND);
        }

        $pessoa = $servidor->pessoa;
        $endereco = optional($pessoa->enderecos->first());
        $cidade = optional($endereco?->cidade);
        $lotacao = optional($pessoa->lotacoes->first());
        $fotoPessoa = FotoPessoa::where('pes_id', '=', $pessoa->pes_id)->get();

        return response()->json([
            'message' => 'Servidor Temporario carregado com sucesso!',
            'servidor_temporario' => [
                'pessoa' => [
                    'pes_id' => $pessoa->pes_id,
                    'pes_nome' => $pessoa->pes_nome,
                    'pes_data_nascimento' => $pessoa->pes_data_nascimento,
                    'pes_sexo' => $pessoa->pes_sexo,
                    'pes_mae' => $pessoa->pes_mae,
                    'pes_pai' => $pessoa->pes_pai,
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
                'servidor_temporario' => [
                    'st_data_admissao' => $servidor->st_data_admissao,
                    'st_data_demissao' => $servidor->st_data_demissao,
                ],
                'lotacao' => $lotacao ? [
                    'unid_id' => $lotacao->unid_id,
                    'lot_data_lotacao' => $lotacao->lot_data_lotacao,
                    'lot_data_remocao' => $lotacao->lot_data_remocao,
                    'lot_portaria' => $lotacao->lot_portaria,
                ] : null,
                'foto' => $fotoPessoa
            ]
        ], Response::HTTP_OK);
    }

    // public function update(ServidorTemporarioRequest $servidorTemporarioRequest, $pes_id)
    // {
    //     $validated = $servidorTemporarioRequest->validated();

    //     $servidorTemporario = ServidorTemporario::where('pes_id', $pes_id)->first();

    //     if (!$servidorTemporario)
    //         return response()->json(['message' => 'Servidor Temporario não encontrado.'], Response::HTTP_NOT_FOUND);

    //     $servidorTemporario->update(['st_data_admissao' => $validated['st_data_admissao'], 'st_data_demissao' => $validated['st_data_demissao']]);

    //     return response()->json([
    //         'message' => 'Servidor Temporario atualizado com sucesso!',
    //         'servidor_temporario' => $servidorTemporario
    //     ]);
    // }

    public function update(ServidorTemporarioRequest $servidorTemporarioRequest, $pes_id)
    {

        $servidorTemporar = ServidorTemporario::where('pes_id', $pes_id)->first();

        if (!$servidorTemporar)
            return response()->json(['message' => 'Servidor Temporario não encontrado.'], Response::HTTP_NOT_FOUND);

        $validated = $servidorTemporarioRequest->validated();

        try {
            DB::beginTransaction();

            $pessoa = Pessoa::findOrFail($pes_id);
            $pessoa->update([
                'pes_nome' => $validated['pes_nome'],
                'pes_data_nascimento' => $validated['pes_data_nascimento'],
                'pes_sexo' => $validated['pes_sexo'],
                'pes_mae' => $validated['pes_mae'],
                'pes_pai' => $validated['pes_pai'],
            ]);

            $servidorTemporario = ServidorTemporario::updateOrCreate(
                ['pes_id' => $pes_id],
                [
                    'st_data_admissao' => $validated['st_data_admissao'],
                    'st_data_demissao' => $validated['st_data_demissao'],
                ]
            );
            

            $cidade = Cidade::updateOrCreate(
                ['cid_nome' => $validated['cid_nome'], 'cid_uf' => $validated['cid_uf']],
            );

            $endereco = Endereco::updateOrCreate(
                ['end_logradouro' => $validated['end_logradouro'], 'end_numero' => $validated['end_numero']],
                [
                    'end_tipo_logradouro' => $validated['end_tipo_logradouro'],
                    'end_bairro' => $validated['end_bairro'],
                    'cid_id' => $cidade->cid_id
                ]
            );

            PessoaEndereco::updateOrCreate(
                ['pes_id' => $pes_id],
                ['end_id' => $endereco->end_id]
            );

            $lotacao = Lotacao::updateOrCreate(
                ['pes_id' => $pes_id],
                [
                    'unid_id' => $validated['unid_id'],
                    'lot_data_lotacao' => $validated['lot_data_lotacao'],
                    'lot_data_remocao' => $validated['lot_data_remocao'],
                    'lot_portaria' => $validated['lot_portaria']
                ]
            );

            DB::commit();

            return response()->json([
                'message' => 'Servidor Temporario atualizado com sucesso!',
                'pessoa' => $pessoa,
                'endereco' => $endereco,
                'servidor_temporario' => $servidorTemporario,
                'lotacao'  => $lotacao
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar Servidor Temporario.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($pes_id)
    {
        $deleted = ServidorTemporario::where('pes_id', $pes_id)->delete();

        if ($deleted === 0)
            return response()->json(['message' => 'Servidor Temporario não encontrado.'], Response::HTTP_NOT_FOUND);

        return response()->json(['message' => 'Servidor Temporario deletado com sucesso!'], Response::HTTP_OK);
    }
}
