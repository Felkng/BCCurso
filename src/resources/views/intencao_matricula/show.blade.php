@extends('layouts.main')

@section('title', 'Detalhes da Intenção de Matrícula')

@section('content')
<div class="custom-container">
    <div>
        <div>
            <i class="fas fa-graduation-cap fa-2x"></i>
            <h3 class="smaller-font">Detalhes da Intenção de Matrícula</h3>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header text-white div-form">
                    Intenção de Matrícula: {{ $intencao_matricula->numero_periodo }}º Semestre - {{ $intencao_matricula->ano }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">ID:</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $intencao_matricula->id }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Número do Semestre:</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $intencao_matricula->numero_periodo }}º
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Ano:</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $intencao_matricula->ano }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Disciplinas:</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            @if($intencao_matricula->disciplinas->count() > 0)
                                <div class="table-responsive mt-2">
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
                                                            $disciplinasDoPeriodo = $intencao_matricula->disciplinas->where('periodo', $periodo);
                                                        @endphp
                                                        
                                                        @if($disciplinasDoPeriodo->count() > 0)
                                                            <ul class="list-unstyled mb-0">
                                                                @foreach($disciplinasDoPeriodo as $disciplina)
                                                                    <li class="mb-2 small">{{ $disciplina->nome }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <div class="text-muted text-center small">
                                                                <i>Nenhuma disciplina</i>
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
                                                            $disciplinasDoPeriodo = $intencao_matricula->disciplinas->where('periodo', $periodo);
                                                        @endphp
                                                        
                                                        @if($disciplinasDoPeriodo->count() > 0)
                                                            <ul class="list-unstyled mb-0">
                                                                @foreach($disciplinasDoPeriodo as $disciplina)
                                                                    <li class="mb-2 small">{{ $disciplina->nome }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <div class="text-muted text-center small">
                                                                <i>Nenhuma disciplina</i>
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
                                                        $disciplinasOptativas = $intencao_matricula->disciplinas->where('optativa', true);
                                                    @endphp
                                                    
                                                    @if($disciplinasOptativas->count() > 0)
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach($disciplinasOptativas as $disciplina)
                                                                <li class="mb-2">
                                                                    <span class="small">{{ $disciplina->nome }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <div class="text-muted text-center small">
                                                            <i>Nenhuma disciplina optativa</i>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-muted">
                                    Nenhuma disciplina associada
                                </div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Criado em:</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $intencao_matricula->created_at->format('d/m/Y H:i:s') }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Atualizado em:</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $intencao_matricula->updated_at->format('d/m/Y H:i:s') }}
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex gap-2">
                        <a href="{{ route('intencao_matricula.index') }}" class="btn custom-button custom-button-castastrar-tcc">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <form action="{{ route('intencao_matricula.destroy', $intencao_matricula->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta intenção de matrícula?')">
                                <i class="fas fa-trash"></i> Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
    
    .table-responsive {
        overflow-x: auto; /* Permitir scroll horizontal apenas em telas muito pequenas */
    }
}
</style>
@stop