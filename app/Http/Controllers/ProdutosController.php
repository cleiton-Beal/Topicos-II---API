<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestProduto;
use App\Models\ClassificacaoFiscal;
use App\Models\Produtos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use stdClass;

class ProdutosController extends Controller
{

    public function CreateProduto(RequestProduto $request) {
        try {
            Log::info($request);
            $produtos = Produtos::create($request->all());
            return response()->json(['Sucesso' => true, 'Mensagem' => 'Produto Cadastrada com Sucesso!']);
        }
        catch (Exception $e) {
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao cadastrar produtos, entre em contato com o Suporte!']);
        }
    }

    public function getProduto($consulta) {

        try {
            if($consulta == 'all'){
               $query = Produtos::select('produtos.*','categorias.nome as categoria')->join('categorias','categorias.id','=','produtos.categoria')->orderBy('nome', 'asc')->get();
            }
            else {
                $query = Produtos::select('produtos.*','categorias.nome as categoria')->join('categorias','categorias.id','=','produtos.categoria')->where('produtos.nome','LIKE', '%'.$consulta.'%')->orWhere('produtos.classificacaoFiscal','LIKE','%'.$consulta.'%')->orWhere('produtos.categoria','LIKE','%'.$consulta.'%')->orWhere('produtos.codBar','LIKE','%'.$consulta.'%')->orderBy('nome','asc')->get();
            }
            return response()->json(['Sucesso' => true, 'Mensagem' => 'Produtos Buscadas com Sucesso!' , 'Produtos' => $query]);
        } catch (Exception $e){
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao buscar produtps, entre em contato com o Suporte!']);
        }
    }

    public function updateProduto(Request $request) {
        try {
            if(!empty($request->id)){
                Log::info($request);
                $produto = Produtos::find($request->id);
                $produto->nome = ($request->nome)?:$produto->nome;
                $produto->valor = ($request->valor)?: $produto->valor;
                $produto->codBar = ($request->codBar)?: $produto->codBar;
                $produto->categoria = ($request->categoria)?: $produto->categoria;
                $produto->classificacaoFiscal = ($request->classificacaoFiscal)?: $produto->classificacaoFiscal;
                $produto->save();
                return response()->json(['Sucesso' => true, 'Mensagem' => 'Produto Atualizado com Sucesso!']);
            }
            else {
                return response()->json(['Sucesso' => false, 'Mensagem' => 'Necessário o envio de um ID para modificação!']);
            }
        }
        catch (Exception $e) {
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao cadastrar Produto, entre em contato com o Suporte!']);
        }
    }

    public function destroy($id) {
        try {
            $cliente = Produtos::destroy($id);
            return response()->json(['Sucesso' => true, 'Mensagem' => 'Exclusão ocorrida com Sucesso!']);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao excluir Produtos, entre em contato com o Suporte!']);
        }
    }
}
