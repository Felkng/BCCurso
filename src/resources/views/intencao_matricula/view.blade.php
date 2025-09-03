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
                
                <div class="form-group mb-3">
                    <label for="numero_periodo" class="form-label">Número do Período <span class="text-danger">*</span></label>
                    <select class="form-control @error('numero_periodo') is-invalid @enderror" id="numero_periodo" name="numero_periodo" required>
                        <option value="">Selecione o período</option>
                        @for($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ old('numero_periodo') == $i ? 'selected' : '' }}>{{ $i }}º Período</option>
                        @endfor
                    </select>
                    @error('numero_periodo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="ano" class="form-label">Ano <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('ano') is-invalid @enderror" id="ano" name="ano" value="{{ old('ano', date('Y')) }}" min="2020" max="{{ date('Y') + 5 }}" required>
                    @error('ano')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Disciplinas</label>
                    <div class="row">
                        @foreach($disciplinas as $disciplina)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="disciplinas[]" id="disciplina_{{ $disciplina->id }}" value="{{ $disciplina->id }}" {{ in_array($disciplina->id, old('disciplinas', [])) ? 'checked' : '' }}>
                                    <label for="disciplina_{{ $disciplina->id }}" class="form-check-label">
                                        {{ $disciplina->nome }} ({{ $disciplina->periodo }}º período)
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn custom-button">Cadastrar</button>
                    <a href="{{ route('intencao_matricula.index') }}" class="btn custom-button custom-button-castastrar-tcc ms-2">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop