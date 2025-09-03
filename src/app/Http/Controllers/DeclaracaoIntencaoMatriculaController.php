<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeclaracaoIntencaoMatriculaRequest;
use App\Models\Aluno;
use App\Models\IntencaoMatricula;
use App\Models\Disciplina;
use App\Models\DeclaracaoIntencaoMatricula;
use App\Models\DeclaracaoIntencaoMatriculaDisciplina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeclaracaoIntencaoMatriculaController extends Controller
{
    /**
     * Construtor que restringe acesso apenas a alunos
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->hasRole('aluno')) {
                return redirect()->route('postagem.display')->with('error', 'Acesso não autorizado.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aluno = Auth::user()->aluno;
        
        $declaracoes = DeclaracaoIntencaoMatricula::where('aluno_id', $aluno->id)
                                                 ->orderBy('created_at', 'desc')
                                                 ->with('intencoesMatricula.disciplinas')
                                                 ->get();
        
        return view('declaracao_intencao_matricula.index', compact('aluno', 'declaracoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aluno = Auth::user()->aluno;
        
        $intencoesMatricula = IntencaoMatricula::orderBy('ano', 'desc')
                                      ->orderBy('numero_periodo')
                                      ->get();
        
        return view('declaracao_intencao_matricula.create', compact('aluno', 'intencoesMatricula'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ano' => ['required', 'integer', 'min:2020', 'max:' . (date('Y') + 5)],
            'periodo' => ['required', 'integer', 'min:1', 'max:2'],
            'intencao_matricula_id' => ['required', 'exists:intencao_matricula,id'],
        ]);

        $aluno = Auth::user()->aluno;

        $declaracao = new DeclaracaoIntencaoMatricula();
        $declaracao->ano = $request->ano;
        $declaracao->periodo = $request->periodo;
        $declaracao->aluno_id = $aluno->id;
        $declaracao->save();



        return redirect()->route('declaracao_intencao_matricula.index')->with('success', 'Declaração de intenção de matrícula enviada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $aluno = Auth::user()->aluno;
        
        $declaracao = DeclaracaoIntencaoMatricula::where('id', $id)
                                              ->where('aluno_id', $aluno->id)
                                              ->with('intencoesMatricula.disciplinas')
                                              ->firstOrFail();
        
        return view('declaracao_intencao_matricula.show', compact('declaracao'));
    }
    
    /**
     * Exibe o formulário para selecionar disciplinas
     */
    public function selecionarDisciplinas()
    {
        $aluno = Auth::user()->aluno;
        
        $anoAtual = date('Y');
        $anos = [$anoAtual, $anoAtual + 1];
        
        $periodos = [1, 2];
        
        return view('declaracao_intencao_matricula.selecionar_disciplinas', compact('aluno', 'anos', 'periodos'));
    }
    
    /**
     * Busca as disciplinas para um determinado ano e período
     */
    public function buscarDisciplinas(Request $request)
    {
        $request->validate([
            'ano' => ['required', 'integer', 'min:2020', 'max:' . (date('Y') + 5)],
            'periodo' => ['required', 'integer', 'min:1', 'max:2'],
        ]);
        
        $aluno = Auth::user()->aluno;
        
        if (!$aluno) {
            return response()->json([
                'error' => true,
                'message' => 'Não foi possível encontrar o aluno associado ao seu usuário.'
            ], 404);
        }


        $intencaoMatricula = IntencaoMatricula::where('ano', $request->ano)
                                            ->where('numero_periodo', $request->periodo)
                                            ->first();
        
        if (!$intencaoMatricula) {
            return response()->json([
                'error' => true,
                'message' => 'Não foi encontrada intenção de matrícula para o ano e período selecionados.'
            ], 404);
        }
        
        $disciplinas = $intencaoMatricula->disciplinas()->orderBy('periodo')->get();
        
        $declaracaoExistente = DeclaracaoIntencaoMatricula::where('aluno_id', $aluno->id)
                                                      ->where('ano', $request->ano)
                                                      ->where('periodo', $request->periodo)
                                                      ->first();
        
        $disciplinasSelecionadas = [];
        if ($declaracaoExistente) {
            $disciplinasSelecionadas = $declaracaoExistente->disciplinasDeclaradas()
                                                      ->pluck('disciplina_id')
                                                      ->toArray();
        }

        $disciplinasPorPeriodo = [];
        foreach ($disciplinas as $disciplina) {
            if ($disciplina->optativa) {
                if (!isset($disciplinasPorPeriodo['optativas'])) {
                    $disciplinasPorPeriodo['optativas'] = [];
                }
                $disciplinasPorPeriodo['optativas'][] = [
                    'id' => $disciplina->id,
                    'nome' => $disciplina->nome,
                    'periodo' => null,
                    'optativa' => true,
                    'intencao_matricula_id' => $intencaoMatricula->id,
                    'selecionada' => in_array($disciplina->id, $disciplinasSelecionadas)
                ];
            } else {
                $periodo = $disciplina->periodo;
                if (!isset($disciplinasPorPeriodo[$periodo])) {
                    $disciplinasPorPeriodo[$periodo] = [];
                }
                $disciplinasPorPeriodo[$periodo][] = [
                    'id' => $disciplina->id,
                    'nome' => $disciplina->nome,
                    'periodo' => $disciplina->periodo,
                    'optativa' => false,
                    'intencao_matricula_id' => $intencaoMatricula->id,
                    'selecionada' => in_array($disciplina->id, $disciplinasSelecionadas)
                ];
            }
        }
        
        return response()->json([
            'intencao_matricula_id' => $intencaoMatricula->id,
            'disciplinas' => $disciplinasPorPeriodo,
            'tem_selecao_anterior' => !empty($disciplinasSelecionadas),
            'disciplinas_selecionadas' => $disciplinasSelecionadas
        ]);
    }
    
    /**
     * Salva as disciplinas selecionadas pelo aluno
     */
    public function salvarDisciplinas(Request $request)
    {
        $request->validate([
            'ano' => ['required', 'integer', 'min:2020', 'max:' . (date('Y') + 5)],
            'periodo' => ['required', 'integer', 'min:1', 'max:2'],
            'intencao_matricula_id' => ['required', 'exists:intencao_matricula,id'],
            'disciplinas' => ['required', 'array', 'min:1'],
            'disciplinas.*' => ['required', 'exists:disciplina,id'],
        ]);
        
        $aluno = Auth::user()->aluno;
        
        if (!$aluno) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Não foi possível encontrar o aluno associado ao seu usuário.');
        }
        
        if (empty($request->disciplinas)) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Você precisa selecionar pelo menos uma disciplina.');
        }
        
        $disciplinasIds = $request->disciplinas;
        $disciplinasExistentes = Disciplina::whereIn('id', $disciplinasIds)
            ->pluck('id')
            ->toArray();
            
        $disciplinasInvalidas = array_diff($disciplinasIds, $disciplinasExistentes);
        if (!empty($disciplinasInvalidas)) {
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Algumas disciplinas selecionadas não existem no sistema. Por favor, atualize a página e tente novamente.');
        }
        
        DB::beginTransaction();
        
        try {
            $declaracao = DeclaracaoIntencaoMatricula::where('aluno_id', $aluno->id)
                                                  ->where('ano', $request->ano)
                                                  ->where('periodo', $request->periodo)
                                                  ->first();
            
            if (!$declaracao) {
                $declaracao = new DeclaracaoIntencaoMatricula();
                $declaracao->ano = $request->ano;
                $declaracao->periodo = $request->periodo;
                $declaracao->aluno_id = $aluno->id;
                $declaracao->save();
                
            } else {
                try {
                    $declaracao->disciplinasDeclaradas()->delete();
                } catch (\Exception $e) {
                    \Log::error('Erro ao excluir disciplinas antigas:', [
                        'message' => $e->getMessage(),
                        'declaracao_id' => $declaracao->id
                    ]);
                }
            }
            
            $intencaoMatricula = IntencaoMatricula::find($request->intencao_matricula_id);
            if (!$intencaoMatricula) {
                throw new \Exception("Intenção de matrícula com ID {$request->intencao_matricula_id} não foi encontrada.");
            }
            
            $disciplinasInseridas = 0;
            $disciplinasParaInserir = [];
            
            foreach ($request->disciplinas as $disciplinaId) {
                if (empty($disciplinaId) || !is_numeric($disciplinaId)) {
                    continue;
                }
                
                $disciplinaId = (int) $disciplinaId;
                
                $disciplina = Disciplina::find($disciplinaId);
                if (!$disciplina) {
                    continue;
                }
                
                $disciplinasParaInserir[] = [
                    'disciplina_id' => $disciplinaId,
                    'intencao_matricula_id' => $request->intencao_matricula_id,
                    'declaracao_id' => $declaracao->id
                ];
                $disciplinasInseridas++;
            }
            
            if (!empty($disciplinasParaInserir)) {
                try {
                    
                    $declaracaoExiste = DeclaracaoIntencaoMatricula::find($declaracao->id);
                        
                    if (!$declaracaoExiste) {
                        throw new \Exception("Declaração com ID {$declaracao->id} não foi encontrada no banco de dados.");
                    }

                    foreach ($disciplinasParaInserir as $index => $disciplinaData) {
                        $resultado = DeclaracaoIntencaoMatriculaDisciplina::criarComValidacao(
                            $disciplinaData['declaracao_id'],
                            $disciplinaData['intencao_matricula_id'],
                            $disciplinaData['disciplina_id']
                        );
                        
                        if ($resultado) {
                            \Log::info("Disciplina {$index} inserida com sucesso:", [
                                'disciplina_id' => $disciplinaData['disciplina_id'],
                                'disciplina_declarada_id' => $resultado->id
                            ]);
                        } else {
                            \Log::warning("Falha ao inserir disciplina {$index}:", [
                                'disciplina_id' => $disciplinaData['disciplina_id']
                            ]);
                        }
                    }
                    
                    \Log::info('Todas as disciplinas foram processadas', [
                        'quantidade' => count($disciplinasParaInserir)
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Erro ao inserir disciplinas:', [
                        'message' => $e->getMessage(),
                        'codigo' => $e->getCode()
                    ]);
                }
            }
            
            DB::commit();
            
            return redirect()->route('declaracao_intencao_matricula.selecionar_disciplinas', [
                'ano' => $request->ano,
                'periodo' => $request->periodo
            ])->with('success', 'Disciplinas declaradas com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erro ao salvar disciplinas: ' . $e->getMessage());
        }
    }
}