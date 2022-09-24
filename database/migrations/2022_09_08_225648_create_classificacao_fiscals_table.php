<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassificacaoFiscalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classificacao_fiscals', function (Blueprint $table) {
            $table->id();
            $table->String('Codigo')->nullable(true);
            $table->String('Descricao')->nullable(true);
            $table->date('Data_Inicio')->nullable(true);
            $table->date('Data_Fim')->nullable(true);
            $table->String('Tipo_Ato')->nullable(true);
            $table->String('Numero_Ato')->nullable(true);
            $table->String('Ano_Ato')->nullable(true);
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
        Schema::dropIfExists('classificacao_fiscals');
    }
}
