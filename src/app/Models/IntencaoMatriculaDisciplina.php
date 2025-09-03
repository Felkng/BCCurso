<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IntencaoMatriculaDisciplina extends Model
{
    use HasFactory;
    
    protected $table = 'intencao_matricula_disciplina';
    
    protected $fillable = [
        'intencao_matricula_id',
        'disciplina_id'
    ];
    
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
     * Scope para buscar por intenção de matrícula
     */
    public function scopePorIntencaoMatricula($query, $intencaoMatriculaId)
    {
        return $query->where('intencao_matricula_id', $intencaoMatriculaId);
    }
    
    /**
     * Relacionamento com as declarações de intenção de matrícula que usam esta combinação
     * de intenção de matrícula e disciplina
     */
    public function declaracoesIntencaoMatricula(): HasMany
    {
        return $this->hasMany(
            DeclaracaoIntencaoMatriculaDisciplina::class, 
            ['intencao_matricula_id', 'disciplina_id'],
            ['intencao_matricula_id', 'disciplina_id']
        );
    }
    
    /**
     * Scope para buscar por disciplina
     */
    public function scopePorDisciplina($query, $disciplinaId)
    {
        return $query->where('disciplina_id', $disciplinaId);
    }
    
    /**
     * Scope para buscar associações com disciplinas de um período específico
     */
    public function scopeComDisciplinasDoPeriodo($query, $periodo)
    {
        return $query->whereHas('disciplina', function ($q) use ($periodo) {
            $q->where('periodo', $periodo);
        });
    }
    
    /**
     * Scope para buscar associações de um ano específico
     */
    public function scopeDoAno($query, $ano)
    {
        return $query->whereHas('intencaoMatricula', function ($q) use ($ano) {
            $q->where('ano', $ano);
        });
    }
    
    /**
     * Método para verificar se uma associação já existe
     */
    public static function associacaoExiste($intencaoMatriculaId, $disciplinaId): bool
    {
        return self::where('intencao_matricula_id', $intencaoMatriculaId)
                   ->where('disciplina_id', $disciplinaId)
                   ->exists();
    }
    
    /**
     * Método para criar associação se não existir
     */
    public static function criarAssociacao($intencaoMatriculaId, $disciplinaId): self|bool
    {
        if (!self::associacaoExiste($intencaoMatriculaId, $disciplinaId)) {
            return self::create([
                'intencao_matricula_id' => $intencaoMatriculaId,
                'disciplina_id' => $disciplinaId
            ]);
        }
        
        return false;
    }
    
    /**
     * Método para remover associação
     */
    public static function removerAssociacao($intencaoMatriculaId, $disciplinaId): bool
    {
        return self::where('intencao_matricula_id', $intencaoMatriculaId)
                   ->where('disciplina_id', $disciplinaId)
                   ->delete() > 0;
    }
    
    /**
     * Método para obter estatísticas da associação
     */
    public static function estatisticas(): array
    {
        return [
            'total_associacoes' => self::count(),
            'intencoes_com_disciplinas' => self::distinct('intencao_matricula_id')->count(),
            'disciplinas_associadas' => self::distinct('disciplina_id')->count(),
            'associacoes_por_ano' => self::with('intencaoMatricula')
                                         ->get()
                                         ->groupBy('intencaoMatricula.ano')
                                         ->map(function ($group) {
                                             return $group->count();
                                         })
                                         ->toArray()
        ];
    }
    
    /**
     * Método para declarar esta disciplina em uma declaração de intenção de matrícula
     * 
     * @param int $declaracaoId ID da declaração de intenção de matrícula
     * @return \App\Models\DeclaracaoIntencaoMatriculaDisciplina|false
     */
    public function declararEm($declaracaoId)
    {
        return DeclaracaoIntencaoMatriculaDisciplina::criarComValidacao(
            $declaracaoId,
            $this->intencao_matricula_id,
            $this->disciplina_id
        );
    }
    
    /**
     * Método para obter todas as declarações que incluem esta disciplina
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function todasDeclaracoes()
    {
        return DeclaracaoIntencaoMatriculaDisciplina::where('intencao_matricula_id', $this->intencao_matricula_id)
            ->where('disciplina_id', $this->disciplina_id)
            ->get();
    }
}