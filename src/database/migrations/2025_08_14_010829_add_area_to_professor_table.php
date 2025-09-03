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
        Schema::table('professor', function (Blueprint $table) {
            $table->string('area')->nullable()->after('biografia');
        });
        
        // Migrar dados existentes do user para professor
        $this->migrateUserDataToProfessor();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professor', function (Blueprint $table) {
            $table->dropColumn('area');
        });
    }
    
    /**
     * Migra dados de titulacao, biografia e area do User para Professor
     */
    private function migrateUserDataToProfessor()
    {
        // Busca todos os usuários que possuem dados para migrar
        $users = \DB::table('users')
            ->whereNotNull('titulacao')
            ->orWhereNotNull('biografia')
            ->orWhereNotNull('area')
            ->get();
            
        foreach ($users as $user) {
            // Busca o servidor relacionado ao usuário
            $servidor = \DB::table('servidor')->where('user_id', $user->id)->first();
            
            if ($servidor) {
                // Busca o professor relacionado ao servidor
                $professor = \DB::table('professor')->where('servidor_id', $servidor->id)->first();
                
                if ($professor) {
                    // Atualiza os dados do professor com os dados do usuário
                    \DB::table('professor')
                        ->where('id', $professor->id)
                        ->update([
                            'titulacao' => $user->titulacao ?? $professor->titulacao,
                            'biografia' => $user->biografia ?? $professor->biografia,
                            'area' => $user->area,
                            'updated_at' => now()
                        ]);
                }
            }
        }
    }
};
