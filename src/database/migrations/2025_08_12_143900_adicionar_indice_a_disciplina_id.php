<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdicionarIndiceADisciplinaId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('declarar_intencao_matricula_disciplina', function (Blueprint $table) {
            // Adiciona um índice para o campo disciplina_id para melhorar o desempenho
            $table->index('disciplina_id', 'idx_disciplina_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('declarar_intencao_matricula_disciplina', function (Blueprint $table) {
            $table->dropIndex('idx_disciplina_id');
        });
    }
}
