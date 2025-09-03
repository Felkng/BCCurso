<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeclaracaoIntencaoMatriculaDisciplina extends Model
{
    use HasFactory;
    
    protected $table = 'declarar_intencao_matricula_disciplina';
    
    protected $fillable = [
        'declarar_intencao_matricula_id',
        'intencao_matricula_id',
        'disciplina_id'
    ];
    
    /**
     * Relacionamento com DeclaracaoIntencaoMatricula
     */
    public function declaracaoIntencaoMatricula(): BelongsTo
    {
        return $this->belongsTo(DeclaracaoIntencaoMatricula::class, 'declarar_intencao_matricula_id');
    }
    
    /**
     * Relacionamento com IntencaoMatricula
     */
    public function intencaoMatricula(): BelongsTo
    {
        return $this->belongsTo(IntencaoMatricula::class, 'intencao_matricula_id');
    }
    
    /**
     * Relacionamento com Disciplina
     */
    public function disciplina(): BelongsTo
    {
        return $this->belongsTo(Disciplina::class, 'disciplina_id');
    }
    
    /**
     * Relacionamento com IntencaoMatriculaDisciplina (via chave composta)
     */
    public function intencaoMatriculaDisciplina(): BelongsTo
    {
        // Como estamos referenciando uma chave composta, precisamos criar um relacionamento personalizado
        // que relaciona a disciplina e a intenção de matrícula com a respectiva combinação na tabela
        // intencao_matricula_disciplina
        return $this->belongsTo(
            IntencaoMatriculaDisciplina::class,
            ['intencao_matricula_id', 'disciplina_id'],
            ['intencao_matricula_id', 'disciplina_id']
        );
    }
    
    /**
     * Método auxiliar para verificar se existe um IntencaoMatriculaDisciplina 
     * correspondente a esta disciplina declarada
     */
    public function verificarExistenciaIntencaoMatriculaDisciplina()
    {
        return IntencaoMatriculaDisciplina::where('intencao_matricula_id', $this->intencao_matricula_id)
            ->where('disciplina_id', $this->disciplina_id)
            ->exists();
    }
    
    /**
     * Scope para buscar por declaração de intenção de matrícula
     */
    public function scopePorDeclaracaoIntencaoMatricula($query, $declaracaoId)
    {
        return $query->where('declarar_intencao_matricula_id', $declaracaoId);
    }
    
    /**
     * Scope para buscar por intenção de matrícula
     */
    public function scopePorIntencaoMatricula($query, $intencaoMatriculaId)
    {
        return $query->where('intencao_matricula_id', $intencaoMatriculaId);
    }
    
    /**
     * Scope para buscar por disciplina
     */
    public function scopePorDisciplina($query, $disciplinaId)
    {
        return $query->where('disciplina_id', $disciplinaId);
    }
    
    /**
     * Método estático para criar um novo registro com validação prévia
     * 
     * @param int $declaracaoId ID da declaração de intenção de matrícula
     * @param int $intencaoMatriculaId ID da intenção de matrícula
     * @param int $disciplinaId ID da disciplina
     * @return DeclaracaoIntencaoMatriculaDisciplina|false
     */
    public static function criarComValidacao($declaracaoId, $intencaoMatriculaId, $disciplinaId)
    {
        // Verifica se existe a combinação de intenção de matrícula e disciplina
        $existeIntencaoDisciplina = IntencaoMatriculaDisciplina::where('intencao_matricula_id', $intencaoMatriculaId)
            ->where('disciplina_id', $disciplinaId)
            ->exists();
            
        if (!$existeIntencaoDisciplina) {
            \Log::warning('Tentativa de declarar disciplina que não existe na intenção de matrícula:', [
                'declaracao_id' => $declaracaoId,
                'intencao_matricula_id' => $intencaoMatriculaId,
                'disciplina_id' => $disciplinaId
            ]);
            return false;
        }
        
        // Verifica se o registro já existe
        $existeDeclaracao = self::where('declarar_intencao_matricula_id', $declaracaoId)
            ->where('intencao_matricula_id', $intencaoMatriculaId)
            ->where('disciplina_id', $disciplinaId)
            ->exists();
            
        if ($existeDeclaracao) {
            // Se já existe, retorna o registro existente
            return self::where('declarar_intencao_matricula_id', $declaracaoId)
                ->where('intencao_matricula_id', $intencaoMatriculaId)
                ->where('disciplina_id', $disciplinaId)
                ->first();
        }
        
        // Cria o novo registro
        $declaracaoDisciplina = new self();
        $declaracaoDisciplina->declarar_intencao_matricula_id = $declaracaoId;
        $declaracaoDisciplina->intencao_matricula_id = $intencaoMatriculaId;
        $declaracaoDisciplina->disciplina_id = $disciplinaId;
        $declaracaoDisciplina->save();
        
        return $declaracaoDisciplina;
    }
    
    /**
     * Método para obter o nome da disciplina via relacionamento
     */
    public function getNomeDisciplinaAttribute()
    {
        return $this->disciplina->nome ?? 'Disciplina não encontrada';
    }
    
    /**
     * Método para obter o período da disciplina via relacionamento
     */
    public function getPeriodoDisciplinaAttribute()
    {
        return $this->disciplina->periodo ?? null;
    }
    
    /**
     * Método para obter a carga horária da disciplina via relacionamento
     */
    public function getCargaHorariaDisciplinaAttribute()
    {
        return $this->disciplina->carga_horaria ?? null;
    }
}
