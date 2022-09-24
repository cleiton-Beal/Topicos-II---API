<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClassificacaoFiscalController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('createUser', [UserController::class, 'CreateUser']);
Route::post('login', [UserController::class, 'login']);

Route::prefix('Clientes')->middleware('auth:sanctum')->group( function(){
    Route::post('create', [ClientesController::class, 'CreateCliente']);
    Route::get('buscar/{consulta}',[ClientesController::class, 'getClientes']);
    Route::post('edit', [ClientesController::class, 'updateCliente']);
    Route::delete('delete/{id}', [ClientesController::class, 'destroy']);

});

Route::prefix('Categorias')->middleware('auth:sanctum')->group( function(){
    Route::post('create', [CategoriaController::class, 'CreateCategoria']);
    Route::get('buscar/{consulta}',[CategoriaController::class, 'getCategoria']);
    Route::post('edit', [CategoriaController::class, 'updateCategoria']);
    Route::delete('delete/{id}', [CategoriaController::class, 'destroy']);

});

Route::prefix('Produtos')->middleware('auth:sanctum')->group( function(){
    Route::post('create', [ProdutosController::class, 'CreateProduto']);
    Route::get('buscar/{consulta}',[ProdutosController::class, 'getProduto']);
    Route::post('edit', [ProdutosController::class, 'updateProduto']);
    Route::delete('delete/{id}', [ProdutosController::class, 'destroy']);

});

Route::prefix('ClassificacoesFiscais')->middleware('auth:sanctum')->group( function(){
    Route::get('rodar', [ClassificacaoFiscalController::class, 'RodarClassificacaoFiscal']);
    Route::get('Buscar/{consulta}', [ClassificacaoFiscalController::class, 'getCategoria']);
});

Route::middleware('auth:sanctum')->group( function(){

    Route::post('vender', [VendaController::class , 'GerarVenda']);
    Route::get('relatorio/{data}', [VendaController::class, 'GerarRelatorioDia']);
});
