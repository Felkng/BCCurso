@extends('layouts.main')

@section('title', 'Cadastrar Intenção de Matrícula')

@section('content')
<div class="custom-container">
    <div>
        <div>
            <i class="fas fa-graduation-cap fa-2x"></i>
            <h3 class="smaller-font">Cadastrar Intenção de Matrícula</h3>
        </div>
    </div>
</div>

<div class="container mt-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header text-white div-form">
            Nova Intenção de Matrícula
        </div>
        <div class="card-body">
            <form action="{{ route('intencao_matricula.store') }}" method="POST">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="numero_periodo" class="form-label">Número do Semestre <span class="text-danger">*</span></label>
                            <select class="form-control @error('numero_periodo') is-invalid @enderror" id="numero_periodo" name="numero_periodo" required>
                                <option value="">Selecione o Semestre</option>
                                @for($i = 1; $i <= 2; $i++)
                                    <option value="{{ $i }}" {{ old('numero_periodo') == $i ? 'selected' : '' }}>{{ $i }}º Semestre</option>
                                @endfor
                            </select>
                            @error('numero_periodo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ano" class="form-label">Ano <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('ano') is-invalid @enderror" id="ano" name="ano" value="{{ old('ano', date('Y')) }}" min="2020" max="{{ date('Y') + 5 }}" required>
                            @error('ano')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Selecione as Disciplinas por Período</label>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <!-- Primeira linha: Períodos 1-5 -->
                            <thead class="table-light">
                                <tr>
                                    @for($periodo = 1; $periodo <= 5; $periodo++)
                                        <th class="text-center" style="width: 20%">{{ $periodo }}º Período</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="vertical-align: top;">
                                    @for($periodo = 1; $periodo <= 5; $periodo++)
                                        <td style="width: 20%; padding: 15px;">
                                            @php
                                                $disciplinasDoPeriodo = $disciplinas->where('periodo', $periodo);
                                            @endphp
                                            
                                            @if($disciplinasDoPeriodo->count() > 0)
                                                @foreach($disciplinasDoPeriodo as $disciplina)
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" 
                                                               class="form-check-input" 
                                                               name="disciplinas[]" 
                                                               id="disciplina_{{ $disciplina->id }}" 
                                                               value="{{ $disciplina->id }}" 
                                                               {{ in_array($disciplina->id, old('disciplinas', [])) ? 'checked' : '' }}>
                                                        <label for="disciplina_{{ $disciplina->id }}" class="form-check-label small">
                                                            {{ $disciplina->nome }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="text-muted text-center small">
                                                    <i>Nenhuma disciplina cadastrada</i>
                                                </div>
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                        
                        <!-- Segunda linha: Períodos 6-10 -->
                        <table class="table table-bordered" style="margin-top: 0;">
                            <thead class="table-light">
                                <tr>
                                    @for($periodo = 6; $periodo <= 10; $periodo++)
                                        <th class="text-center" style="width: 20%">{{ $periodo }}º Período</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="vertical-align: top;">
                                    @for($periodo = 6; $periodo <= 10; $periodo++)
                                        <td style="width: 20%; padding: 15px;">
                                            @php
                                                $disciplinasDoPeriodo = $disciplinas->where('periodo', $periodo);
                                            @endphp
                                            
                                            @if($disciplinasDoPeriodo->count() > 0)
                                                @foreach($disciplinasDoPeriodo as $disciplina)
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" 
                                                               class="form-check-input" 
                                                               name="disciplinas[]" 
                                                               id="disciplina_{{ $disciplina->id }}" 
                                                               value="{{ $disciplina->id }}" 
                                                               {{ in_array($disciplina->id, old('disciplinas', [])) ? 'checked' : '' }}>
                                                        <label for="disciplina_{{ $disciplina->id }}" class="form-check-label small">
                                                            {{ $disciplina->nome }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="text-muted text-center small">
                                                    <i>Nenhuma disciplina cadastrada</i>
                                                </div>
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                        
                        <!-- Seção de Disciplinas Optativas -->
                        <table class="table table-bordered" style="margin-top: 20px;">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 100%">Disciplinas Optativas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="vertical-align: top;">
                                    <td style="padding: 15px;">
                                        @php
                                            $disciplinasOptativas = $disciplinas->where('optativa', true);
                                        @endphp
                                        
                                        @if($disciplinasOptativas->count() > 0)
                                            <div class="row">
                                                @foreach($disciplinasOptativas as $disciplina)
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" 
                                                                class="form-check-input" 
                                                                name="disciplinas[]" 
                                                                id="disciplina_{{ $disciplina->id }}" 
                                                                value="{{ $disciplina->id }}" 
                                                                {{ in_array($disciplina->id, old('disciplinas', [])) ? 'checked' : '' }}>
                                                            <label for="disciplina_{{ $disciplina->id }}" class="form-check-label small">
                                                                {{ $disciplina->nome }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-muted text-center small">
                                                <i>Nenhuma disciplina optativa cadastrada</i>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="d-flex flex-wrap mb-2">
                                <button type="button" id="selectAll" class="btn btn-outline-primary btn-sm mb-1 me-1">
                                    <i class="fas fa-check-square"></i> Selecionar Todas
                                </button>
                                <button type="button" id="selectEven" class="btn btn-outline-info btn-sm mb-1 me-1">
                                    <i class="fas fa-check-square"></i> Períodos Pares
                                </button>
                                <button type="button" id="selectOdd" class="btn btn-outline-info btn-sm mb-1 me-1">
                                    <i class="fas fa-check-square"></i> Períodos Ímpares
                                </button>
                                <button type="button" id="unselectAll" class="btn btn-outline-secondary btn-sm mb-1">
                                    <i class="fas fa-square"></i> Limpar Seleção
                                </button>
                            </div>
                            <div class="selected-count">
                                <span class="badge bg-info" id="countSelected">0 disciplinas selecionadas</span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                
                <div class="mt-4">
                    <a href="{{ route('intencao_matricula.index') }}" class="btn custom-button ms-2">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn custom-button">
                        <i class="fas fa-save"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[name="disciplinas[]"]');
    const selectAllBtn = document.getElementById('selectAll');
    const selectEvenBtn = document.getElementById('selectEven');
    const selectOddBtn = document.getElementById('selectOdd');
    const unselectAllBtn = document.getElementById('unselectAll');
    const countSelected = document.getElementById('countSelected');

    // Função para atualizar contador
    function updateCount() {
        const selectedCount = document.querySelectorAll('input[name="disciplinas[]"]:checked').length;
        countSelected.textContent = selectedCount + ' disciplina' + (selectedCount !== 1 ? 's' : '') + ' selecionada' + (selectedCount !== 1 ? 's' : '');
        
        // Atualizar cor do badge baseado na quantidade
        countSelected.className = 'badge ' + (selectedCount > 0 ? 'bg-success' : 'bg-info');
    }

    // Adicionar evento para cada checkbox
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', updateCount);
    });

    // Botão selecionar todas
    selectAllBtn.addEventListener('click', function() {
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
        });
        updateCount();
    });

    // Botão selecionar períodos pares
    selectEvenBtn.addEventListener('click', function() {
        // Limpa todas as seleções primeiro
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
        
        // Seleciona checkboxes nos períodos pares (2, 4, 6, 8, 10)
        document.querySelectorAll('table').forEach(function(table, tableIndex) {
            table.querySelectorAll('th').forEach(function(th, thIndex) {
                const periodoText = th.innerText;
                const periodoMatch = periodoText.match(/(\d+)º/);
                
                if (periodoMatch) {
                    const periodo = parseInt(periodoMatch[1]);
                    // Se é um período par
                    if (periodo % 2 === 0) {
                        // Seleciona todos os checkboxes nesta coluna
                        const cellIndex = thIndex;
                        table.querySelectorAll('tbody tr').forEach(function(tr) {
                            const td = tr.querySelectorAll('td')[cellIndex];
                            if (td) {
                                td.querySelectorAll('input[name="disciplinas[]"]').forEach(function(cb) {
                                    cb.checked = true;
                                });
                            }
                        });
                    }
                }
            });
        });
        
        updateCount();
    });

    // Botão selecionar períodos ímpares
    selectOddBtn.addEventListener('click', function() {
        // Limpa todas as seleções primeiro
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
        
        // Seleciona checkboxes nos períodos ímpares (1, 3, 5, 7, 9)
        document.querySelectorAll('table').forEach(function(table, tableIndex) {
            table.querySelectorAll('th').forEach(function(th, thIndex) {
                const periodoText = th.innerText;
                const periodoMatch = periodoText.match(/(\d+)º/);
                
                if (periodoMatch) {
                    const periodo = parseInt(periodoMatch[1]);
                    // Se é um período ímpar
                    if (periodo % 2 !== 0) {
                        // Seleciona todos os checkboxes nesta coluna
                        const cellIndex = thIndex;
                        table.querySelectorAll('tbody tr').forEach(function(tr) {
                            const td = tr.querySelectorAll('td')[cellIndex];
                            if (td) {
                                td.querySelectorAll('input[name="disciplinas[]"]').forEach(function(cb) {
                                    cb.checked = true;
                                });
                            }
                        });
                    }
                }
            });
        });
        
        updateCount();
    });

    // Botão limpar seleção
    unselectAllBtn.addEventListener('click', function() {
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
        updateCount();
    });

    // Inicializar contador
    updateCount();

    // Validação do formulário
    document.querySelector('form').addEventListener('submit', function(e) {
        const selectedDisciplinas = document.querySelectorAll('input[name="disciplinas[]"]:checked').length;
        
        if (selectedDisciplinas === 0) {
            e.preventDefault();
            alert('Por favor, selecione pelo menos uma disciplina.');
            return false;
        }
    });
});
</script>

<style>
.table td {
    vertical-align: top !important;
}

.form-check {
    margin-bottom: 8px;
}

.form-check-label {
    font-size: 0.9rem;
    line-height: 1.3;
    cursor: pointer;
}

.form-check-input {
    margin-top: 0.2rem;
}

.table-responsive {
    overflow-x: hidden; /* Removendo scroll horizontal */
    max-height: none; /* Removendo a altura máxima para evitar cortes */
}

.table {
    margin-bottom: 0; /* Removendo o espaço entre as tabelas */
    table-layout: fixed; /* Garante tamanho uniforme das colunas */
    width: 100%;
}

.table th, .table td {
    width: 20%; /* Cada coluna ocupa exatamente 20% da largura */
}

/* Responsividade para telas menores */
@media (max-width: 768px) {
    .table th, .table td {
        font-size: 0.85rem;
    }
    
    .form-check-label {
        font-size: 0.8rem;
    }
    
    .table-responsive {
        overflow-x: auto; /* Permitir scroll horizontal apenas em telas muito pequenas */
    }
}
</style>

@stop