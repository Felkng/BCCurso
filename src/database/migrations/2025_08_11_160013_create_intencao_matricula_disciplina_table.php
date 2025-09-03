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
        Schema::create('intencao_matricula_disciplina', function (Blueprint $table) {
            $table->foreignId('intencao_matricula_id')->constrained('intencao_matricula')->onDelete('cascade');
            $table->foreignId('disciplina_id')->constrained('disciplina')->onDelete('cascade');
            $table->primary(['intencao_matricula_id', 'disciplina_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intencao_matricula_disciplina');
    }
};
