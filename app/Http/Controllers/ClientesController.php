<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCliente;
use App\Models\clientes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientesController extends Controller
{

    public function CreateCliente(RequestCliente $request) {
        try {
            Log::info($request);
            $cliente = clientes::create($request->all());
            return response()->json(['Sucesso' => true, 'Mensagem' => 'Cliente Cadastrado com Sucesso!']);
        }
        catch (Exception $e) {
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao cadastrar Cliente, entre em contato com o Suporte!']);
        }
    }

    public function getClientes($consulta, Request $request) {

        try {
            if ($request->id){
                $query = clientes::orderBy('nome', 'asc')->where('id', $request->id)->first();

                return response()->json(['Sucesso' => true, 'Mensagem' => 'Cliente Buscado com Sucesso!' , 'Cliente' => $query ]);
            }
            else if($consulta == 'all'){
               $query = clientes::orderBy('nome', 'asc')->get();
            }
            else {
                $query = clientes::where('nome','LIKE', '%'.$consulta.'%')->orWhere('email','LIKE', '%'.$consulta.'%')->orWhere('cpfCnpj','LIKE', '%'.$consulta.'%')->orWhere('telefone','LIKE', '%'.$consulta.'%')->orderBy('nome','asc')->get();
            }
            return response()->json(['Sucesso' => true, 'Mensagem' => 'Clientes Buscados com Sucesso!' , 'Clientes' => $query]);
        } catch (Exception $e){
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao buscar Cliente, entre em contato com o Suporte!']);
        }
    }

    public function updateCliente(Request $request) {
        try {
            if(!empty($request->id)){
                Log::info($request);
                $cliente = clientes::find($request->id);
                $cliente->nome = ($request->nome)?:$cliente->nome;
                $cliente->cpfCnpj = ($request->cpfCnpj)?:$cliente->cpfCnpj;
                $cliente->telefone = ($request->telefone)?:$cliente->telefone;
                $cliente->email = ($request->email)?:$cliente->email;
                $cliente->save();
                return response()->json(['Sucesso' => true, 'Mensagem' => 'Cliente Atualizado com Sucesso!']);
            }
            else {
                return response()->json(['Sucesso' => false, 'Mensagem' => 'Necessário o envio de um ID para modificação!']);
            }
        }
        catch (Exception $e) {
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao cadastrar Cliente, entre em contato com o Suporte!']);
        }
    }

    public function destroy($id) {
        try {
            $cliente = clientes::destroy($id);
            return response()->json(['Sucesso' => true, 'Mensagem' => 'Exclusão ocorrida com Sucesso!']);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao excluir Cliente, entre em contato com o Suporte!']);
        }
    }
}
