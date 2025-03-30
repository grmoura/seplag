<?php

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\UnidadeEnderecoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['controller' => CidadeController::class], function () {
    Route::get('/cidades', 'index');
    Route::get('/cidades/{cid_id}', 'show');
    Route::post('/cidades', 'store');
    Route::put('/cidades/{cid_id}', 'update');
    Route::delete('/cidades/{cid_id}', 'destroy');
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
