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
        Schema::table('aluno', function (Blueprint $table) {
            $table->integer('matricula')->after('id');
            $table->foreignId('user_id')->constrained()
                ->onDelete("cascade")->after('matricula');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aluno', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('matricula');
            $table->dropColumn('user_id');
        });
    }
};
