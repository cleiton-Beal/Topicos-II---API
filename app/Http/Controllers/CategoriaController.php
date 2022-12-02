<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCategoria;
use App\Models\Categorias;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{

    public function CreateCategoria(RequestCategoria $request) {
        try {
            Log::info($request);
            $categoria = Categorias::create($request->all());
            return response()->json(['Sucesso' => true, 'Mensagem' => 'Categoria Cadastrada com Sucesso!']);
        }
        catch (Exception $e) {
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao cadastrar Categorias, entre em contato com o Suporte!']);
        }
    }

    public function getCategoria($consulta) {

        try {
            if($consulta == 'all'){
               $query = Categorias::orderBy('nome', 'asc')->get();
            }
            else {
                $query = Categorias::where('nome','LIKE', '%'.$consulta.'%')->orderBy('nome','asc')->get();
            }
            return response()->json(['Sucesso' => true, 'Mensagem' => 'Categorias Buscadas com Sucesso!' , 'Categorias' => $query]);
        } catch (Exception $e){
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao buscar Categorias, entre em contato com o Suporte!']);
        }
    }

    public function updateCategoria(Request $request) {
        try {
            if(!empty($request->id)){
                Log::info($request);
                $categoria = Categorias::find($request->id);
                $categoria->nome = ($request->nome)?:$categoria->nome;
                $categoria->cores = ($request->cores)?: $categoria->cores;
                $categoria->save();
                return response()->json(['Sucesso' => true, 'Mensagem' => 'Categoria Atualizada com Sucesso!']);
            }
            else {
                return response()->json(['Sucesso' => false, 'Mensagem' => 'Necessário o envio de um ID para modificação!']);
            }
        }
        catch (Exception $e) {
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao cadastrar Categoria, entre em contato com o Suporte!']);
        }
    }

    public function destroy($id) {
        try {
            $cliente = Categorias::destroy($id);
            return response()->json(['Sucesso' => true, 'Mensagem' => 'Exclusão ocorrida com Sucesso!']);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao excluir Categoria, entre em contato com o Suporte!']);
        }
    }

}
