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
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('favoritavel_type'); // 'App\Models\Postagem' ou 'App\Models\Tcc'
            $table->unsignedBigInteger('favoritavel_id');
            $table->timestamps();
            
            // Índices
            $table->index(['favoritavel_type', 'favoritavel_id']);
            $table->unique(['user_id', 'favoritavel_type', 'favoritavel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoritos');
    }
};
