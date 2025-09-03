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
        Schema::create('disciplina', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('periodo')->unsigned();
            $table->timestamps();
        });

        Schema::create('intencao_matricula', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_periodo')->unsigned();
            $table->integer('ano')->unsigned();
            $table->unique(['numero_periodo', 'ano']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intencao_matricula');
        Schema::dropIfExists('disciplina');
    }
};
