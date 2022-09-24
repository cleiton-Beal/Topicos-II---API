<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestVendas;
use App\Models\ProdutoVendas;
use App\Models\Venda;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VendaController extends Controller
{
    public function GerarVenda(RequestVendas $request) {

        try {
            $user = Auth::user()->id;

            $venda = Venda::create([
                'cliente' => $request->cliente,
                'usuario' => $user
            ]);

            foreach ($request->produtos as $produto) {

                $produto = ProdutoVendas::create([
                    'quantidade' => $produto['quantidade'],
                    'produto' => $produto['id'],
                    'venda' => $venda->id,
                    'valorProduto' => $produto['valorProduto'],
                    'nomeProduto' => $produto['nomeProduto'],
                ]);
            }
            return response()->json(['Sucesso' => true, 'Mensagem' => 'Venda Efetuada com sucesso!']);
        }
        catch(Exception $e) {
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao Cadastrar venda, entre em contato com o Suporte!']);
        }
    }

    public function GerarRelatorioDia($data) {
        $somaDosProdutos = [];
        $numVendas = Venda::where('created_at', '>=',$data.' 00:00:00')->where('created_at', '<=', $data.' 23:59:59')->count();
        $produtoVenda = ProdutoVendas::select('produto')->where('created_at', '>=',$data.' 00:00:00')->where('created_at', '<=', $data.' 23:59:59')->groupBy('produto')->get();
        foreach ($produtoVenda as $key => $prodVenda) {

            $somaProd = ProdutoVendas::select('quantidade')->where('created_at', '>=',$data.' 00:00:00')->where('created_at', '<=', $data.' 23:59:59')->where('produto', $prodVenda->produto)->sum('quantidade');
            $somavalor = ProdutoVendas::select(DB::raw("sum(valorProduto*quantidade) as total"))->where('created_at', '>=',$data.' 00:00:00')->where('created_at', '<=', $data.' 23:59:59')->where('produto', $prodVenda->produto)->first();
            $nome = ProdutoVendas::select('nomeProduto')->where('created_at', '>=',$data.' 00:00:00')->where('created_at', '<=', $data.' 23:59:59')->where('produto', $prodVenda->produto)->first();

            $somaDosProdutos[$nome['nomeProduto']] = ['QuantidadeVendida' => $somaProd, 'ValorVendido' => json_decode($somavalor)->total];
        }

        return response()->json(['Sucesso' => true, 'NumeroVendas' => $numVendas, 'VendasPorProduto' => $somaDosProdutos, 'Mensagem' => 'Relatório gerado com Sucesso! ']);

    }
}
