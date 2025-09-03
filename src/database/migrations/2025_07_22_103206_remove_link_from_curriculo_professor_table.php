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
        Schema::table('curriculo_professor', function (Blueprint $table) {
            $table->dropColumn('link'); // Remove a coluna 'link'
        });
    }

    public function down(): void
    {
        Schema::table('curriculo_professor', function (Blueprint $table) {
            $table->string('link')->after('curriculo'); // Adiciona a coluna 'link' de volta
        });
    }
};
