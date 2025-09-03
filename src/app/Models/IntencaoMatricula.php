<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntencaoMatricula extends Model
{
    use HasFactory;
    
    protected $table = 'intencao_matricula';
    
    protected $fillable = [
        'numero_periodo',
        'ano'
    ];
    
    /**
     * Relacionamento many-to-many com Disciplina
     */
    public function disciplinas()
    {
        return $this->belongsToMany(
            Disciplina::class,
            'intencao_matricula_disciplina',
            'intencao_matricula_id',
            'disciplina_id'
        )->withTimestamps();
    }
    
    /**
     * Relacionamento direto com a tabela pivot
     */
    public function intencaoMatriculaDisciplinas()
    {
        return $this->hasMany(IntencaoMatriculaDisciplina::class, 'intencao_matricula_id');
    }
    
    /**
     * Método para adicionar disciplina
     */
    public function adicionarDisciplina($disciplinaId): bool
    {
        return IntencaoMatriculaDisciplina::criarAssociacao($this->id, $disciplinaId) !== false;
    }
    
    /**
     * Método para remover disciplina
     */
    public function removerDisciplina($disciplinaId): bool
    {
        return IntencaoMatriculaDisciplina::removerAssociacao($this->id, $disciplinaId);
    }
    
    // Validação adicional para o período
    public function setNumeroPeriodoAttribute($value)
    {
        if ($value < 1 || $value > 2) {
            throw new \InvalidArgumentException('O número do período deve estar entre 1 e 10');
        }
        
        $this->attributes['numero_periodo'] = $value;
    }
    
    /**
     * Método para obter declarações de intenção associadas a esta intenção de matrícula
     */
    public function declaracoesIntencao()
    {
        return DeclaracaoIntencaoMatricula::whereIn('id', function($query) {
            $query->select('declarar_intencao_matricula_id')
                ->from('declarar_intencao_matricula_disciplina')
                ->where('intencao_matricula_id', $this->id)
                ->distinct();
        });
    }
}