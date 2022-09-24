<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->String('nome')->nullable(false);
            $table->float('valor')->nullable(false);
            $table->String('codBar')->nullable(true);
            $table->unsignedBigInteger('categoria')->nullable(true);
            $table->foreign('categoria')->references('id')->on('categorias');
            $table->unsignedBigInteger('classificacaoFiscal')->nullable(true);
            $table->foreign('classificacaoFiscal')->references('id')->on('classificacao_fiscals');
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
        Schema::dropIfExists('produtos');
    }
}
