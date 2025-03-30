<?php

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\LotacaoController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\PessoaEnderecoController;
use App\Http\Controllers\ServidorEfetivoController;
use App\Http\Controllers\ServidorTemporarioController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\UnidadeEnderecoController;
use App\Models\ServidorEfetivo;
use App\Models\ServidorTemporario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['controller' => CidadeController::class], function () {
    Route::get('/cidade', 'index');
    Route::get('/cidade/{cid_id}', 'show');
    Route::post('/cidade', 'store');
    Route::put('/cidade/{cid_id}', 'update');
    Route::delete('/cidade/{cid_id}', 'destroy');
});

Route::group(['controller' => EnderecoController::class], function () {
    Route::get('/endereco', 'index');
    Route::get('/endereco/{end_id}', 'show');
    Route::post('/endereco', 'store');
    Route::put('/endereco/{end_id}', 'update');
    Route::delete('/endereco/{end_id}', 'destroy');
});

Route::group(['controller' => UnidadeController::class], function () {
    Route::get('/unidade', 'index');
    Route::get('/unidade/{end_id}', 'show');
    Route::post('/unidade', 'store');
    Route::put('/unidade/{end_id}', 'update');
    Route::delete('/unidade/{end_id}', 'destroy');
});

Route::group(['controller' => UnidadeEnderecoController::class], function () {
    Route::get('/unidade_endereco', 'index');
    Route::get('/unidade_endereco/{unid_id}/{end_id}', 'show');
    Route::post('/unidade_endereco', 'store');
    Route::put('/unidade_endereco/{unid_id}/{end_id}', 'update');
    Route::delete('/unidade_endereco/{unid_id}/{end_id}', 'destroy');
});

Route::group(['controller' => PessoaController::class], function () {
    Route::get('/pessoa', 'index');
    Route::get('/pessoa/{pes_id}', 'show');
    Route::post('/pessoa', 'store');
    Route::put('/pessoa/{pes_id}', 'update');
    Route::delete('/pessoa/{pes_id}', 'destroy');
});

Route::group(['controller' => ServidorEfetivoController::class], function () {
    Route::get('/servidor_efetivo', 'index');
    Route::get('/servidor_efetivo/{pes_id}', 'show');
    Route::post('/servidor_efetivo', 'store');
    Route::put('/servidor_efetivo/{pes_id}/{se_matricula}', 'update');
    Route::delete('/servidor_efetivo/{pes_id}', 'destroy');
});

Route::group(['controller' => ServidorTemporarioController::class], function () {
    Route::get('/servidor_temporario', 'index');
    Route::get('/servidor_temporario/{pes_id}', 'show');
    Route::post('/servidor_temporario', 'store');
    Route::put('/servidor_temporario/{pes_id}', 'update');
    Route::delete('/servidor_temporario/{pes_id}', 'destroy');
});

Route::group(['controller' => PessoaEnderecoController::class], function () {
    Route::get('/pessoa_endereco', 'index');
    Route::get('/pessoa_endereco/{pes_id}/{end_id}', 'show');
    Route::post('/pessoa_endereco', 'store');
    Route::put('/pessoa_endereco/{pes_id}/{end_id}', 'update');
    Route::delete('/pessoa_endereco/{pes_id}/{end_id}', 'destroy');
});

Route::group(['controller' => LotacaoController::class], function () {
    Route::get('/lotacao', 'index');
    Route::get('/lotacao/{lot_id}', 'show');
    Route::post('/lotacao', 'store');
    Route::put('/lotacao/{lot_id}', 'update');
    Route::delete('/lotacao/{lot_id}', 'destroy');
});