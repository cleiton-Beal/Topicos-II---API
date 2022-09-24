<?php

namespace App\Http\Controllers;

use App\Models\ClassificacaoFiscal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use stdClass;

class ClassificacaoFiscalController extends Controller
{
    public function RodarClassificacaoFiscal(){
        $classificacoes = file_get_contents('/home/cleiton/Área de Trabalho/Curso Flutter/topicos 2/OlaVenda/public/classificacaiFiscalJson/ClassificacaoFiscal.json');
        Log::info($classificacoes);
        $classificacoes = json_decode($classificacoes)->Nomenclaturas;
        foreach ($classificacoes as $classificacao) {
            $classifica = new stdClass;
            $classifica->Codigo = $classificacao->Codigo;
            $classifica->Descricao = $classificacao->Descricao;
            $classifica->Data_Inicio = date('Y-m-d',strtotime($classificacao->Data_Inicio));
            $classifica->Data_Fim = date('Y-m-d',strtotime($classificacao->Data_Fim));
            $classifica->Tipo_Ato = $classificacao->Tipo_Ato;
            $classifica->Numero_Ato = $classificacao->Numero_Ato;
            $classifica->Ano_Ato = $classificacao->Ano_Ato;
            ClassificacaoFiscal::create((array)$classifica);
        }

    }

    public function getCategoria($consulta) {

        try {
            if($consulta == 'all'){
               $query = ClassificacaoFiscal::orderBy('Descricao', 'asc')->paginate(20);
            }
            else {
                $query = ClassificacaoFiscal::where('Codigo','LIKE', '%'.$consulta.'%')->orWhere('Descricao','LIKE', '%'.$consulta.'%')->orderBy('Descricao','asc')->get();
            }
            return response()->json(['Sucesso' => true, 'Mensagem' => 'Categorias Buscadas com Sucesso!' , 'Categorias' => $query]);
        } catch (Exception $e){
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao buscar Categorias, entre em contato com o Suporte!']);
        }
    }
}
