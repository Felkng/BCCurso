@extends('layouts.main')

@section('title', 'Editar Disciplina')

@section('content')

<div class="custom-container">
    <div>
        <div>
            <i class="fas fa-book fa-2x"></i>
            <h3 class="smaller-font">Editar Disciplina</h3>
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
            Editar Disciplina
        </div>
        <div class="card-body">
            <form action="{{ route('disciplina.update', $disciplina->id) }}" method="POST" id="editDisciplinaForm">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label for="nome" class="form-label">Nome da Disciplina <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $disciplina->nome) }}" placeholder="Informe o nome da disciplina" required>
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="optativa" class="form-label">Disciplina Optativa?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="optativa" name="optativa" {{ old('optativa', $disciplina->optativa) ? 'checked' : '' }}>
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
                            <option value="{{ $i }}" {{ old('periodo', $disciplina->periodo) == $i ? 'selected' : '' }}>{{ $i }}º Período</option>
                        @endfor
                    </select>
                    @error('periodo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn custom-button">Atualizar</button>
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
                periodoSelect.setAttribute('disabled', 'disabled');
                periodoSelect.value = '';
                periodoRequired.style.display = 'none';
                periodoContainer.classList.add('text-muted');
                // Adicionar estilo para desabilitar completamente o campo
                periodoSelect.style.pointerEvents = 'none';
                periodoSelect.style.backgroundColor = '#e9ecef';
                periodoSelect.style.opacity = '0.65';
                periodoSelect.style.cursor = 'not-allowed';
            } else {
                periodoSelect.removeAttribute('disabled');
                periodoSelect.setAttribute('required', 'required');
                periodoRequired.style.display = 'inline';
                periodoContainer.classList.remove('text-muted');
                // Remover estilos que desabilitam o campo
                periodoSelect.style.pointerEvents = '';
                periodoSelect.style.backgroundColor = '';
                periodoSelect.style.opacity = '';
                periodoSelect.style.cursor = '';
            }
        }
        
        // Verificar estado inicial
        togglePeriodoField();
        
        // Adicionar listener para mudanças
        optativaCheckbox.addEventListener('change', togglePeriodoField);
        
        // Interceptar o envio do formulário para garantir que o campo periodo seja enviado mesmo quando desabilitado
        document.getElementById('editDisciplinaForm').addEventListener('submit', function(e) {
            if (optativaCheckbox.checked) {
                // Temporariamente remove o atributo disabled para que o valor seja enviado
                periodoSelect.removeAttribute('disabled');
                periodoSelect.value = '0';
                
                // O formulário será enviado normalmente
                // O disabled será reaplicado após o envio do formulário, se necessário
                setTimeout(function() {
                    if (optativaCheckbox.checked) {
                        periodoSelect.setAttribute('disabled', 'disabled');
                    }
                }, 0);
            }
        });
    });
</script>
@stop

<style>
/* Estilo para campos desabilitados */
select:disabled, input:disabled {
    pointer-events: none !important;
    background-color: #e9ecef !important;
    opacity: 0.65 !important;
    cursor: not-allowed !important;
}
</style>
