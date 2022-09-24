<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutoVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto_vendas', function (Blueprint $table) {
            $table->id();
            $table->float('quantidade')->nullable(false);
            $table->unsignedBigInteger('produto')->nullable(false);
            $table->foreign('produto')->references('id')->on('produtos');
            $table->unsignedBigInteger('venda')->nullable(false);
            $table->foreign('venda')->references('id')->on('vendas');
            $table->float('valorProduto')->nullable(true);
            $table->String('nomeProduto')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produto_vendas');
    }
}
