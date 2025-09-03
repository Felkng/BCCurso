@extends('layouts.main')

@section('title', 'Cadastrar Disciplina')

@section('content')

<div class="custom-container">
    <div>
        <div>
            <i class="fas fa-book fa-2x"></i>
            <h3 class="smaller-font">Cadastrar Disciplina</h3>
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
            Nova Disciplina
        </div>
        <div class="card-body">
            <form action="{{ route('disciplina.store') }}" method="POST">
                @csrf
                
                <div class="form-group mb-3">
                    <label for="nome" class="form-label">Nome da Disciplina <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" placeholder="Informe o nome da disciplina" required>
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="optativa" class="form-label">Disciplina Optativa?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="optativa" name="optativa" {{ old('optativa') ? 'checked' : '' }}>
                        <label class="form-check-label" for="optativa">
                            Sim, esta é uma disciplina optativa
                        </label>
                    </div>
                    <small class="form-text text-muted">Marque esta opção caso a disciplina seja optativa. Disciplinas optativas não estão associadas a um período específico.</small>
                </div>
                
                <div class="form-group mb-3" id="periodo-container">
                    <label for="periodo" class="form-label">Período <span class="text-danger periodo-required">*</span></label>
                    <select class="form-control @error('periodo') is-invalid @enderror" id="periodo" name="periodo">
                        <option value="">Selecione o período</option>
                        @for($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ old('periodo') == $i ? 'selected' : '' }}>{{ $i }}º Período</option>
                        @endfor
                    </select>
                    @error('periodo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn custom-button">Cadastrar</button>
                    <a href="{{ route('disciplina.index') }}" class="btn custom-button ms-2">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const optativaCheckbox = document.getElementById('optativa');
        const periodoSelect = document.getElementById('periodo');
        const periodoContainer = document.getElementById('periodo-container');
        const periodoRequired = document.querySelector('.periodo-required');
        
        function togglePeriodoField() {
            if (optativaCheckbox.checked) {
                periodoSelect.removeAttribute('required');
                periodoRequired.style.display = 'none';
                periodoContainer.classList.add('text-muted');
            } else {
                periodoSelect.setAttribute('required', 'required');
                periodoRequired.style.display = 'inline';
                periodoContainer.classList.remove('text-muted');
            }
        }
        
        // Verificar estado inicial
        togglePeriodoField();
        
        // Adicionar listener para mudanças
        optativaCheckbox.addEventListener('change', togglePeriodoField);
    });
</script>
@stop