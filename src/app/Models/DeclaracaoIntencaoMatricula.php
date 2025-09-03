<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeclaracaoIntencaoMatricula extends Model
{
    use HasFactory;
    
    protected $table = 'declarar_intencao_matricula';
    
    protected $fillable = [
        'ano',
        'periodo',
        'aluno_id'
    ];
    
    /**
     * Relacionamento com o aluno
     */
    public function aluno(): BelongsTo
    {
        return $this->belongsTo(Aluno::class);
    }
    
    /**
     * Relacionamento com as intenções de matrícula - redefinido para usar a relação via disciplinas
     * Não é uma relação direta ManyToMany, mas sim obtida através das disciplinas declaradas
     */
    public function intencoesMatricula()
    {
        // Obtém as intenções de matrícula associadas às disciplinas declaradas
        return IntencaoMatricula::whereIn('id', function($query) {
            $query->select('intencao_matricula_id')
                ->from('declarar_intencao_matricula_disciplina')
                ->where('declarar_intencao_matricula_id', $this->id)
                ->distinct();
        });
    }
    
    /**
     * Relacionamento com as disciplinas declaradas
     */
    public function disciplinasDeclaradas(): HasMany
    {
        return $this->hasMany(DeclaracaoIntencaoMatriculaDisciplina::class, 'declarar_intencao_matricula_id');
    }
    
    /**
     * Relacionamento direto com as disciplinas (many-to-many)
     */
    public function disciplinas(): BelongsToMany
    {
        return $this->belongsToMany(
            Disciplina::class,
            'declarar_intencao_matricula_disciplina',
            'declarar_intencao_matricula_id',
            'disciplina_id'
        )->withPivot('intencao_matricula_id')
         ->withTimestamps();
    }
    
    /**
     * Método para verificar se já existe declaração para este aluno no ano/período
     */
    public static function declaracaoExiste($alunoId, $ano, $periodo): bool
    {
        return self::where('aluno_id', $alunoId)
                   ->where('ano', $ano)
                   ->where('periodo', $periodo)
                   ->exists();
    }
    
    /**
     * Método para adicionar uma disciplina à declaração de intenção de matrícula
     */
    public function adicionarDisciplina($intencaoMatriculaId, $disciplinaId): bool
    {
        // Verifica se a disciplina existe na intenção de matrícula
        $existeNaIntencao = IntencaoMatriculaDisciplina::where('intencao_matricula_id', $intencaoMatriculaId)
                                                       ->where('disciplina_id', $disciplinaId)
                                                       ->exists();
        
        if (!$existeNaIntencao) {
            \Log::warning('Tentativa de adicionar disciplina que não existe na intenção de matrícula', [
                'declaracao_id' => $this->id,
                'intencao_matricula_id' => $intencaoMatriculaId,
                'disciplina_id' => $disciplinaId
            ]);
            return false;
        }
        
        // Verifica se a disciplina já foi adicionada a esta declaração
        $jaAdicionada = DeclaracaoIntencaoMatriculaDisciplina::where('declarar_intencao_matricula_id', $this->id)
                                                             ->where('disciplina_id', $disciplinaId)
                                                             ->exists();
        
        if ($jaAdicionada) {
            return true; // Já existe, então consideramos como sucesso
        }
        
        // Adiciona a disciplina
        $disciplinaDeclarada = new DeclaracaoIntencaoMatriculaDisciplina();
        $disciplinaDeclarada->declarar_intencao_matricula_id = $this->id;
        $disciplinaDeclarada->intencao_matricula_id = $intencaoMatriculaId;
        $disciplinaDeclarada->disciplina_id = $disciplinaId;
        
        return $disciplinaDeclarada->save();
    }
    
    /**
     * Método para sincronizar disciplinas em uma declaração de intenção de matrícula
     * 
     * @param int $intencaoMatriculaId ID da intenção de matrícula
     * @param array $disciplinaIds IDs das disciplinas a serem sincronizadas
     * @return array Resultado da sincronização
     */
    public function sincronizarDisciplinas($intencaoMatriculaId, array $disciplinaIds): array
    {
        $resultado = [
            'sucesso' => true,
            'adicionadas' => 0,
            'removidas' => 0,
            'erros' => []
        ];
        
        // Busca todas as disciplinas da intenção de matrícula
        $disciplinasIntencao = IntencaoMatriculaDisciplina::where('intencao_matricula_id', $intencaoMatriculaId)
                                                         ->get();
        
        // Mapeia os IDs de disciplinas válidas na intenção de matrícula
        $disciplinasValidasMap = $disciplinasIntencao->pluck('disciplina_id')->flip()->map(function() { return true; })->toArray();
        
        // Verifica quais disciplinas são válidas (existem na intenção de matrícula)
        $disciplinasValidas = [];
        $disciplinasInvalidas = [];
        
        foreach ($disciplinaIds as $disciplinaId) {
            if (isset($disciplinasValidasMap[$disciplinaId])) {
                $disciplinasValidas[] = $disciplinaId;
            } else {
                $disciplinasInvalidas[] = $disciplinaId;
            }
        }
        
        // Reporta disciplinas inválidas
        if (count($disciplinasInvalidas) > 0) {
            $resultado['sucesso'] = false;
            $resultado['erros'][] = 'Algumas disciplinas não existem na intenção de matrícula: ' . implode(', ', $disciplinasInvalidas);
        }
        
        // Disciplinas atualmente declaradas
        $disciplinasAtuais = $this->disciplinasDeclaradas()
                                 ->where('intencao_matricula_id', $intencaoMatriculaId)
                                 ->pluck('disciplina_id')
                                 ->toArray();
        
        // Disciplinas a serem adicionadas
        $disciplinasParaAdicionar = array_diff($disciplinasValidas, $disciplinasAtuais);
        
        // Disciplinas a serem removidas
        $disciplinasParaRemover = array_diff($disciplinasAtuais, $disciplinasValidas);
        
        // Adiciona novas disciplinas usando IntencaoMatriculaDisciplina
        foreach ($disciplinasParaAdicionar as $disciplinaId) {
            // Encontra a combinação de intenção de matrícula e disciplina
            $intencaoMatriculaDisciplina = $disciplinasIntencao->first(function ($item) use ($disciplinaId) {
                return $item->disciplina_id == $disciplinaId;
            });
            
            if ($intencaoMatriculaDisciplina) {
                // Usa o método declararEm para criar a associação
                $declaracao = $intencaoMatriculaDisciplina->declararEm($this->id);
                if ($declaracao) {
                    $resultado['adicionadas']++;
                } else {
                    $resultado['sucesso'] = false;
                    $resultado['erros'][] = "Erro ao adicionar disciplina ID: {$disciplinaId}";
                }
            }
        }
        
        // Remove disciplinas que não estão mais na lista
        $removidas = $this->disciplinasDeclaradas()
                          ->where('intencao_matricula_id', $intencaoMatriculaId)
                          ->whereIn('disciplina_id', $disciplinasParaRemover)
                          ->delete();
        
        $resultado['removidas'] = $removidas;
        
        return $resultado;
    }
}
