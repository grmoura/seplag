<?php

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\FotoPessoaController;
use App\Http\Controllers\LotacaoController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\PessoaEnderecoController;
use App\Http\Controllers\ServidorEfetivoController;
use App\Http\Controllers\ServidorTemporarioController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\UnidadeEnderecoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('registrar', [AuthController::class, 'registrar']);


// CidadeController
Route::middleware(['auth:api','api'])->group(function () {
    Route::get('/cidade', [CidadeController::class, 'index']);
    Route::get('/cidade/{cid_id}', [CidadeController::class, 'show']);
    Route::post('/cidade', [CidadeController::class, 'store']);
    Route::put('/cidade/{cid_id}', [CidadeController::class, 'update']);
    Route::delete('/cidade/{cid_id}', [CidadeController::class, 'destroy']);
});

// EnderecoController
Route::middleware(['auth:api','api'])->group(function () {
    Route::get('/endereco', [EnderecoController::class, 'index']);
    Route::get('/endereco/{end_id}', [EnderecoController::class, 'show']);
    Route::post('/endereco', [EnderecoController::class, 'store']);
    Route::put('/endereco/{end_id}', [EnderecoController::class, 'update']);
    Route::delete('/endereco/{end_id}', [EnderecoController::class, 'destroy']);
});

// UnidadeController
Route::middleware(['auth:api','api'])->group(function () {
    Route::get('/unidade', [UnidadeController::class, 'index']);
    Route::get('/unidade/{end_id}', [UnidadeController::class, 'show']);
    Route::post('/unidade', [UnidadeController::class, 'store']);
    Route::put('/unidade/{end_id}', [UnidadeController::class, 'update']);
    Route::delete('/unidade/{end_id}', [UnidadeController::class, 'destroy']);
});

// UnidadeEnderecoController
Route::middleware(['auth:api','api'])->group(function () {
    Route::get('/unidade_endereco', [UnidadeEnderecoController::class, 'index']);
    Route::get('/unidade_endereco/{unid_id}/{end_id}', [UnidadeEnderecoController::class, 'show']);
    Route::post('/unidade_endereco', [UnidadeEnderecoController::class, 'store']);
    Route::put('/unidade_endereco/{unid_id}/{end_id}', [UnidadeEnderecoController::class, 'update']);
    Route::delete('/unidade_endereco/{unid_id}/{end_id}', [UnidadeEnderecoController::class, 'destroy']);
});

// PessoaController
Route::middleware(['auth:api','api'])->group(function () {
    Route::get('/pessoa', [PessoaController::class, 'index']);
    Route::get('/pessoa/{pes_id}', [PessoaController::class, 'show']);
    Route::post('/pessoa', [PessoaController::class, 'store']);
    Route::put('/pessoa/{pes_id}', [PessoaController::class, 'update']);
    Route::delete('/pessoa/{pes_id}', [PessoaController::class, 'destroy']);
});

// ServidorEfetivoController
Route::middleware(['auth:api','api'])->group(function () {
    Route::get('/servidor_efetivo', [ServidorEfetivoController::class, 'index']);
    Route::get('/servidor_efetivo/{pes_id}', [ServidorEfetivoController::class, 'show']);
    Route::post('/servidor_efetivo', [ServidorEfetivoController::class, 'store']);
    Route::put('/servidor_efetivo/{pes_id}/{se_matricula}', [ServidorEfetivoController::class, 'update']);
    Route::delete('/servidor_efetivo/{pes_id}', [ServidorEfetivoController::class, 'destroy']);
});

// ServidorTemporarioController
Route::middleware(['auth:api','api'])->group(function () {
    Route::get('/servidor_temporario', [ServidorTemporarioController::class, 'index']);
    Route::get('/servidor_temporario/{pes_id}', [ServidorTemporarioController::class, 'show']);
    Route::post('/servidor_temporario', [ServidorTemporarioController::class, 'store']);
    Route::put('/servidor_temporario/{pes_id}', [ServidorTemporarioController::class, 'update']);
    Route::delete('/servidor_temporario/{pes_id}', [ServidorTemporarioController::class, 'destroy']);
});

// PessoaEnderecoController
Route::middleware(['auth:api','api'])->group(function () {
    Route::get('/pessoa_endereco', [PessoaEnderecoController::class, 'index']);
    Route::get('/pessoa_endereco/{pes_id}/{end_id}', [PessoaEnderecoController::class, 'show']);
    Route::post('/pessoa_endereco', [PessoaEnderecoController::class, 'store']);
    Route::put('/pessoa_endereco/{pes_id}/{end_id}', [PessoaEnderecoController::class, 'update']);
    Route::delete('/pessoa_endereco/{pes_id}/{end_id}', [PessoaEnderecoController::class, 'destroy']);
});

// LotacaoController
Route::middleware(['auth:api','api'])->group(function () {
    Route::get('/lotacao', [LotacaoController::class, 'index']);
    Route::get('/lotacao/{lot_id}', [LotacaoController::class, 'show']);
    Route::post('/lotacao', [LotacaoController::class, 'store']);
    Route::put('/lotacao/{lot_id}', [LotacaoController::class, 'update']);
    Route::delete('/lotacao/{lot_id}', [LotacaoController::class, 'destroy']);
});

// FotoPessoaController
Route::middleware(['auth:api','api'])->group(function () {
    Route::get('/foto_pessoa', [FotoPessoaController::class, 'index']);
    Route::get('/foto_pessoa/{fp_id}', [FotoPessoaController::class, 'show']);
    Route::post('/foto_pessoa', [FotoPessoaController::class, 'store']);
    Route::put('/foto_pessoa/{fp_id}', [FotoPessoaController::class, 'update']);
    Route::delete('/foto_pessoa/{fp_id}', [FotoPessoaController::class, 'destroy']);
});
