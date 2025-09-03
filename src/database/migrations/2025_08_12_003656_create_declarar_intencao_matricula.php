<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('declarar_intencao_matricula', function (Blueprint $table) {
            $table->id();
            $table->integer('ano')->unsigned();
            $table->integer('periodo')->unsigned();
            
            // Define uma chave estrangeira com nome curto personalizado
            $table->foreignId('aluno_id');
            $table->foreign('aluno_id', 'fk_decl_aluno_id')
                  ->references('id')
                  ->on('aluno');
                  
            $table->timestamps();
        });

        Schema::create('declarar_intencao_matricula_disciplina', function (Blueprint $table) {
            $table->id();
            // Define uma chave estrangeira com nome curto personalizado
            $table->foreignId('declarar_intencao_matricula_id');
            $table->foreign('declarar_intencao_matricula_id', 'fk_decl_int_mat_id')
                  ->references('id')
                  ->on('declarar_intencao_matricula')
                  ->onDelete('cascade');
                  
            $table->foreignId('intencao_matricula_id');
            $table->foreignId('disciplina_id');
            
            // Define uma chave estrangeira composta com nome curto personalizado
            $table->foreign(['intencao_matricula_id', 'disciplina_id'], 'fk_int_mat_disc')
                  ->references(['intencao_matricula_id', 'disciplina_id'])
                  ->on('intencao_matricula_disciplina')
                  ->onDelete('cascade');
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declarar_intencao_matricula_disciplina');
        Schema::dropIfExists('declarar_intencao_matricula');
    }
};
