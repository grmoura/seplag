<?php

namespace App\Http\Controllers;

use App\Http\Requests\FotoPessoaRequest;
use App\Http\Requests\PessoaRequest;
use App\Http\Requests\ServidorEfetivoRequest;
use App\Models\Cidade;
use App\Models\Endereco;
use App\Models\FotoPessoa;
use App\Models\Lotacao;
use App\Models\Pessoa;
use App\Models\PessoaEndereco;
use App\Models\ServidorEfetivo;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ServidorEfetivoController extends Controller
{
    public function index()
    {
        $servidores = ServidorEfetivo::with([
            'pessoa.enderecos.cidade',
            'pessoa.lotacoes',
        ])->paginate(3);

        $servidoreEfetivos = $servidores->map(function ($servidor) {
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
                'servidor_efetivo' => [
                    'se_matricula' => $servidor->se_matricula,
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
        $servidores->setCollection($servidoreEfetivos);

        return response()->json([
            'message' => 'Servidores Efetivos carregados com sucesso!',
            'servidores_efetivos' => $servidores
        ]);
    }

    public function store(ServidorEfetivoRequest $servidorEfetivoRequest)
    {
        $validated = $servidorEfetivoRequest->validated();

        try {
            DB::beginTransaction();

            $pessoa = Pessoa::create(['pes_nome' => $validated['pes_nome'], 'pes_data_nascimento' => $validated['pes_data_nascimento'], 'pes_sexo' => $validated['pes_sexo'], 'pes_mae' => $validated['pes_mae'], 'pes_pai' => $validated['pes_pai']]);

            $servidorEfetivo = ServidorEfetivo::create(['pes_id' => $pessoa->pes_id, 'se_matricula' => $validated['se_matricula']]);

            $cidade = Cidade::create(['cid_nome' => $validated['cid_nome'], 'cid_uf' => $validated['cid_uf']]);

            $endereco = Endereco::create(['end_tipo_logradouro' => $validated['end_tipo_logradouro'], 'end_logradouro' => $validated['end_logradouro'], 'end_numero' => $validated['end_numero'], 'end_bairro' => $validated['end_bairro'], 'cid_id' => $cidade->cid_id]);

            $lotacao = Lotacao::create(['pes_id' => $pessoa->pes_id, 'unid_id' => $validated['unid_id'], 'lot_data_lotacao' => $validated['lot_data_lotacao'], 'lot_data_remocao' => $validated['lot_data_remocao'], 'lot_portaria' => $validated['lot_portaria']]);

            PessoaEndereco::create(['pes_id' => $pessoa->pes_id, 'end_id' => $endereco->end_id]);

            if ($validated['fotos'])
                $foto = FotoPessoaController::upload($validated['fotos'], $pessoa->pes_id);

            DB::commit();
            return response()->json([
                'message' => 'Servidor Efetivo cadastrada com sucesso!',
                'pessoa' => $pessoa,
                'endereco' => $endereco,
                'servidor_efetivo' => $servidorEfetivo,
                'lotacao'  => $lotacao,
                'foto' =>  $foto
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao cadastrar Servidor Efetivo.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($pes_id)
    {

        $servidor = ServidorEfetivo::with([
            'pessoa.enderecos.cidade',
            'pessoa.lotacoes',
        ])->where('pes_id', $pes_id)->first();

        if (!$servidor) {
            return response()->json([
                'message' => 'Servidor Efetivo não encontrado.'
            ], Response::HTTP_NOT_FOUND);
        }

        $pessoa = $servidor->pessoa;
        $endereco = optional($pessoa->enderecos->first());
        $cidade = optional($endereco?->cidade);
        $lotacao = optional($pessoa->lotacoes->first());
        $fotoPessoa = FotoPessoa::where('pes_id', '=', $pessoa->pes_id)->get();

        return response()->json([
            'message' => 'Servidor Efetivo carregado com sucesso!',
            'servidor_efetivo' => [
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
                'servidor_efetivo' => [
                    'se_matricula' => $servidor->se_matricula
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

    public function update(ServidorEfetivoRequest $servidorEfetivoRequest, $pes_id)
    {

        $servidorEfetivo = ServidorEfetivo::where('pes_id', $pes_id)->first();

        if (!$servidorEfetivo)
            return response()->json(['message' => 'Servidor Efetivo não encontrado.'], Response::HTTP_NOT_FOUND);

        $validated = $servidorEfetivoRequest->validated();

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

            $servidorEfetivo = ServidorEfetivo::updateOrCreate(
                ['pes_id' => $pes_id],
                ['se_matricula' => $validated['se_matricula']]
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
                'message' => 'Servidor Efetivo atualizado com sucesso!',
                'pessoa' => $pessoa,
                'endereco' => $endereco,
                'servidor_efetivo' => $servidorEfetivo,
                'lotacao'  => $lotacao
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar Servidor Efetivo.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($pes_id)
    {
        $servidorEfetivoExiste = ServidorEfetivo::where('pes_id', $pes_id)->first();

        if (!$servidorEfetivoExiste)
            return response()->json(['message' => 'Servidor Efetivo não encontrado.'], Response::HTTP_OK);

        try {
            DB::beginTransaction();

            ServidorEfetivo::where('pes_id', $pes_id)->delete();
            Lotacao::where('pes_id', $pes_id)->delete();

            $fotos = FotoPessoa::where('pes_id', $pes_id)->get();

            foreach ($fotos as $foto) {
                if ($foto->fp_caminho && Storage::exists($foto->fp_caminho))
                    Storage::delete($foto->fp_caminho);
                $foto->delete();
            }

            $pessoaEndereco = PessoaEndereco::where('pes_id', $pes_id)->first();
            if ($pessoaEndereco) {
                PessoaEndereco::where('pes_id', $pes_id)->delete();
                Endereco::where('end_id', $pessoaEndereco->end_id)->delete();
            }

            Pessoa::where('pes_id', $pes_id)->delete();

            DB::commit();

            return response()->json(['message' => 'Servidor Efetivo deletado com sucesso!'], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Erro ao deletar Servidor Efetivo.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
