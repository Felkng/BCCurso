@extends('layouts.main')

@section('title', 'Disciplinas')

@section('content')
<div class="page-header">
    <div class="container">
        <div class="title-container">
            <div class="page-title">
                <i class="fas fa-book fa-2x"></i>
                <h2>Gerenciar Disciplinas</h2>
            </div>
            
            <div class="row campo-busca">
                <div class="col-md-12">
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar em todos os campos" aria-label="Buscar">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="content-card">
        <div class="card-header">
            <span>Disciplinas</span>
            <button type="button" class="btn-cadastrar" data-bs-toggle="modal" data-bs-target="#createDisciplinaModal">
                <i class="fas fa-plus"></i> Cadastrar
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="disciplinaTable" class="table data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Tipo/Período</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($disciplinas as $disciplina)
                            <tr>
                                <td>{{ $disciplina->id }}</td>
                                <td>
                                    <span class="data-title" data-toggle="tooltip" data-placement="top" title="{{ $disciplina->nome }}">
                                        {{ $disciplina->nome }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                    @if($disciplina->optativa)
                                        Optativa
                                    @else
                                        {{ $disciplina->periodo }}º Período
                                    @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('disciplina.show', $disciplina->id) }}" class="btn-view" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('disciplina.destroy', $disciplina->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-delete" title="Excluir" onclick="confirmDeleteGeneric(this.form, 'Deseja realmente excluir esta disciplina?', '{{ $disciplina->nome }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Nenhuma disciplina encontrada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createDisciplinaModal" tabindex="-1" aria-labelledby="createDisciplinaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header div-form text-white">
                <h5 class="modal-title" id="createDisciplinaModalLabel">
                    <i class="fas fa-book"></i> Nova Disciplina
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createDisciplinaForm" action="{{ route('disciplina.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    
                    <div id="modalErrorContainer" class="alert alert-danger d-none">
                        <ul id="modalErrorList"></ul>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="modal_nome" class="form-label">Nome da Disciplina <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modal_nome" name="nome" placeholder="Informe o nome da disciplina" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="modal_optativa" class="form-label">Disciplina Optativa?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="modal_optativa" name="optativa">
                            <label class="form-check-label" for="modal_optativa">
                                Sim, esta é uma disciplina optativa
                            </label>
                        </div>
                        <small class="form-text text-muted">Marque esta opção caso a disciplina seja optativa. Disciplinas optativas não estão associadas a um período específico.</small>
                    </div>
                    
                    <div class="form-group mb-3" id="modal_periodo_container">
                        <label for="modal_periodo" class="form-label">Período <span class="text-danger periodo-required">*</span></label>
                        <select class="form-control" id="modal_periodo" name="periodo" required>
                            <option value="">Selecione o período</option>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}º Período</option>
                            @endfor
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn custom-button" id="submitBtn">
                        <i class="fas fa-save"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Criar o container de alertas se não existir
    if (!document.querySelector(".alert-container")) {
        const alertContainer = document.createElement("div");
        alertContainer.className = "alert-container";
        document.body.appendChild(alertContainer);
    }

    $("#searchInput").on("keyup", function() {
        var searchText = $(this).val().toLowerCase();
        $("#disciplinaTable tbody tr").filter(function() {
            var rowData = $(this).find("td:not(:last-child)").text().toLowerCase();
            $(this).toggle(rowData.indexOf(searchText) > -1);
        });
    });

    // Limpar formulário quando o modal for aberto
    $('#createDisciplinaModal').on('show.bs.modal', function() {
        $('#createDisciplinaForm')[0].reset();
        $('.form-control').removeClass('is-invalid');
        $('#modalErrorContainer').addClass('d-none');
        $('#submitBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Cadastrar');
        
        // Verificar estado inicial do checkbox
        togglePeriodoField();
    });
    
    // Função para alternar o campo de período com base no checkbox optativa
    function togglePeriodoField() {
        const optativaCheckbox = document.getElementById('modal_optativa');
        const periodoSelect = document.getElementById('modal_periodo');
        const periodoContainer = document.getElementById('modal_periodo_container');
        const periodoRequired = document.querySelector('.periodo-required');
        
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
    
    // Adicionar listener para o checkbox
    $('#modal_optativa').on('change', togglePeriodoField);

    // Submissão do formulário via AJAX
    $('#createDisciplinaForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = $('#submitBtn');
        const formData = new FormData(this);
        
        // Se a disciplina for optativa, garantir que o período seja enviado mesmo que o campo esteja desabilitado
        const optativaCheckbox = document.getElementById('modal_optativa');
        const periodoSelect = document.getElementById('modal_periodo');
        
        if (optativaCheckbox.checked) {
            // Garantir que o campo período seja enviado (com valor vazio ou 0)
            formData.set('periodo', '0');
        }
        
        // Desabilitar botão e mostrar loading
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Cadastrando...');
        
        // Limpar erros anteriores
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#modalErrorContainer').addClass('d-none');
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Fechar modal
                $('#createDisciplinaModal').modal('hide');
                
                // Mostrar mensagem de sucesso usando a função do alerts.js
                showSuccessMessage('Disciplina cadastrada com sucesso!');
                
                // Recarregar página para mostrar nova disciplina
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Cadastrar');
                
                if (xhr.status === 422) {
                    // Erros de validação
                    const errors = xhr.responseJSON.errors;
                    
                    // Mostrar erros nos campos
                    $.each(errors, function(field, messages) {
                        const input = $(`[name="${field}"]`);
                        input.addClass('is-invalid');
                        input.next('.invalid-feedback').text(messages[0]);
                    });
                    
                    // Mostrar resumo dos erros
                    const errorList = $('#modalErrorList');
                    errorList.empty();
                    
                    $.each(errors, function(field, messages) {
                        $.each(messages, function(index, message) {
                            errorList.append(`<li>${message}</li>`);
                        });
                    });
                    
                    $('#modalErrorContainer').removeClass('d-none');
                } else {
                    // Outros erros
                    showErrorMessage('Erro interno do servidor. Tente novamente.');
                }
            }
        });
    });
});
</script>

@include('modal.confirmDeleteGeneric')

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