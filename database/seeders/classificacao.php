<?php

namespace Database\Seeders;

use App\Models\ClassificacaoFiscal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use stdClass;

class classificacao extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classificacoes = file_get_contents('/home/cleiton/Área de Trabalho/Curso Flutter/topicos 2/OlaVenda/public/classificacaiFiscalJson/ClassificacaoFiscal.json');
        Log::info($classificacoes);
        $classificacoes = json_decode($classificacoes)->Nomenclaturas;
        foreach ($classificacoes as $classificacao) {
            $classifica = new stdClass;
            $classifica->Codigo = $classificacao->Codigo;
            if (strlen($classificacao->Descricao) > 3 ) {
                if ($a = strpos($classificacao->Descricao,'(') != null)
                    $classificacao->Descricao = substr($classificacao->Descricao,0,$a);
                if ($a = strpos($classificacao->Descricao,'<') != null)
                    $classificacao->Descricao = substr($classificacao->Descricao,0,$a);
                if (strlen($classificacao->Descricao) < 3 )
                    break;
                if (strpos($classificacao->Descricao,'\\'))
                    break;
            }
            else {
                break;
            }

            $classifica->Descricao = $classificacao->Descricao;
            $classifica->Data_Inicio = date('Y-m-d',strtotime($classificacao->Data_Inicio));
            $classifica->Data_Fim = date('Y-m-d',strtotime($classificacao->Data_Fim));
            $classifica->Tipo_Ato = $classificacao->Tipo_Ato;
            $classifica->Numero_Ato = $classificacao->Numero_Ato;
            $classifica->Ano_Ato = $classificacao->Ano_Ato;
            ClassificacaoFiscal::create((array)$classifica);
        }
    }
}
