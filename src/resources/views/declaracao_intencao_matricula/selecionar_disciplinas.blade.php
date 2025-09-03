@extends('layouts.main')

@section('title', 'Selecionar Disciplinas para Matrícula')

@section('content')
<div class="custom-container">
    <div>
        <div>
            <i class="fas fa-graduation-cap fa-2x"></i>
            <h3 class="smaller-font">Selecionar Disciplinas para Matrícula</h3>
        </div>
    </div>
</div>

<div class="container mt-4">
    <!-- Espaço para notificações flutuantes -->
    <div id="notifications" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>

    <div class="card">
        <div class="card-header text-white div-form">
            Selecione as Disciplinas para Declarar Intenção de Matrícula
        </div>
        <div class="card-body">
            <form id="searchForm" class="mb-4">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="ano" class="form-label">Ano <span class="text-danger">*</span></label>
                            <select class="form-control" id="ano" name="ano" required>
                                <option value="">Selecione o ano</option>
                                @foreach($anos as $ano)
                                    <option value="{{ $ano }}">{{ $ano }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="periodo" class="form-label">Semestre <span class="text-danger">*</span></label>
                            <select class="form-control" id="periodo" name="periodo" required>
                                <option value="">Selecione o semestre</option>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo }}">{{ $periodo }}º Semestre</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" id="buscarBtn" class="btn custom-button w-100">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>
            
            <div id="loadingMessage" class="text-center d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <p class="mt-2">Carregando disciplinas...</p>
            </div>
            
            <form id="disciplinasForm" action="{{ route('declaracao_intencao_matricula.salvar_disciplinas') }}" method="POST" class="d-none">
                @csrf
                <input type="hidden" name="ano" id="anoHidden">
                <input type="hidden" name="periodo" id="periodoHidden">
                <input type="hidden" name="intencao_matricula_id" id="intencaoMatriculaId">
                
                <div class="mb-3">
                    <h5>Disciplinas Disponíveis:</h5>
                    <div id="disciplinasContainer" class="table-responsive">
                        <!-- As disciplinas serão carregadas aqui via JavaScript -->
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="d-flex flex-wrap mb-2">
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
                    <a href="{{ route('declaracao_intencao_matricula.index') }}" class="btn custom-button ms-2">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn custom-button">
                        <i class="fas fa-save"></i> Declarar Intenção
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buscarBtn = document.getElementById('buscarBtn');
    const loadingMessage = document.getElementById('loadingMessage');
    const disciplinasForm = document.getElementById('disciplinasForm');
    const disciplinasContainer = document.getElementById('disciplinasContainer');
    const anoSelect = document.getElementById('ano');
    const periodoSelect = document.getElementById('periodo');
    const anoHidden = document.getElementById('anoHidden');
    const periodoHidden = document.getElementById('periodoHidden');
    const intencaoMatriculaId = document.getElementById('intencaoMatriculaId');
    
    // Limpar o container de notificações ao carregar a página
    // Isso evita que notificações antigas persistam
    const notificationsContainer = document.getElementById('notifications');
    notificationsContainer.innerHTML = '';
    
    // Flag para evitar mostrar múltiplas mensagens
    let messageDisplayed = false;
    
    // Função para mostrar notificações flutuantes
    function showNotification(title, message, type) {
        // Se já mostramos uma mensagem de sucesso ou informação, não mostrar outra 
        // Isso evita duplicação de mensagens
        if (messageDisplayed && (type === 'success' || type === 'info')) {
            console.log('Ignorando notificação duplicada:', { title, message, type });
            return;
        }
        
        // Marcar que uma mensagem foi exibida
        if (type === 'success' || type === 'info') {
            messageDisplayed = true;
        }
        
        const notificationsContainer = document.getElementById('notifications');
        const id = 'toast-' + Date.now();
        
        let bgClass;
        switch(type) {
            case 'error':
                bgClass = 'bg-danger';
                break;
            case 'success':
                bgClass = 'bg-success';
                break;
            case 'info':
                bgClass = 'bg-info';
                break;
            default:
                bgClass = 'bg-primary';
        }
        
        const toast = document.createElement('div');
        toast.className = `toast ${bgClass} text-white`;
        toast.id = id;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="toast-header ${bgClass} text-white">
                <strong class="me-auto">${title}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Fechar"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        `;
        
        notificationsContainer.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast, { autohide: true, delay: 5000 });
        bsToast.show();
        
        // Log para depuração
        console.log('Notificação exibida:', { title, type, id });
        
        // Remover o toast do DOM após ser fechado
        toast.addEventListener('hidden.bs.toast', function() {
            notificationsContainer.removeChild(toast);
        });
    }
    
    // Mostrar notificações flutuantes baseadas em mensagens da sessão
    // Importante: priorizar mensagem de sucesso se existir
    @if(session('success'))
        showNotification('Sucesso', '{!! addslashes(session('success')) !!}', 'success');
        
        // Se temos parâmetros de ano e período na URL após um salvamento bem-sucedido,
        // buscar automaticamente as disciplinas
        @if(request()->has('ano') && request()->has('periodo'))
            // Selecionar os valores nos selects
            anoSelect.value = '{{ request('ano') }}';
            periodoSelect.value = '{{ request('periodo') }}';
            
            // Simular um clique no botão de busca
            setTimeout(() => {
                buscarBtn.click();
            }, 500); // Pequeno atraso para garantir que tudo esteja carregado
        @endif
    @elseif(session('error'))
        showNotification('Erro', '{!! addslashes(session('error')) !!}', 'error');
    @elseif($errors->any())
        showNotification('Erro', '{!! addslashes(implode("<br>", $errors->all())) !!}', 'error');
    @endif
    
    // Botões de seleção
    const unselectAllBtn = document.getElementById('unselectAll');
    const countSelected = document.getElementById('countSelected');
    
    // Função para buscar as disciplinas
    buscarBtn.addEventListener('click', function() {
        const ano = anoSelect.value;
        const periodo = periodoSelect.value;
        
        if (!ano || !periodo) {
            showNotification('Erro', 'Por favor, selecione o ano e período.', 'error');
            return;
        }
        
        // Mostrar mensagem de carregamento
        loadingMessage.classList.remove('d-none');
        disciplinasForm.classList.add('d-none');

        // Enviar requisição AJAX para buscar disciplinas
        fetch('{{ route("declaracao_intencao_matricula.buscar_disciplinas") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                ano: ano,
                periodo: periodo
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            // Esconder mensagem de carregamento
            loadingMessage.classList.add('d-none');
            
            // Verificar se houve erro
            if (data.error) {
                showNotification('Erro', data.message, 'error');
                return;
            }

            
            // Configurar os campos ocultos
            anoHidden.value = ano;
            periodoHidden.value = periodo;
            intencaoMatriculaId.value = data.intencao_matricula_id;
            
            // Montar as tabelas de disciplinas
            let disciplinasHTML = criarTabelasDisciplinas(data.disciplinas);
            disciplinasContainer.innerHTML = disciplinasHTML;
            
            // Mostrar o formulário
            disciplinasForm.classList.remove('d-none');
            
            // Obter o botão de envio
            const submitButton = disciplinasForm.querySelector('button[type="submit"]');
            
            // Se há uma seleção anterior, mostrar mensagem e alterar texto do botão
            if (data.tem_selecao_anterior) {
                // Mostrar mensagem apenas se ainda não exibimos nenhuma mensagem
                if (!messageDisplayed) {
                    showNotification('Informação', 'Você já declarou intenção para este período. As disciplinas selecionadas anteriormente foram carregadas. Você pode alterar sua seleção se desejar.', 'info');
                }
                
                // Alterar texto do botão para "Atualizar"
                submitButton.innerHTML = '<i class="fas fa-save"></i> Atualizar Intenção';
            } else {
                // Texto padrão do botão
                submitButton.innerHTML = '<i class="fas fa-save"></i> Declarar Intenção';
            }
            
            // Configurar os handlers para os botões de seleção
            setupSelectionHandlers();
        })
        .catch(error => {
            loadingMessage.classList.add('d-none');
            const errorMsg = `Ocorreu um erro ao buscar as disciplinas: Não existe Intenção de Matrícula para este ano e período especificado.`;
            showNotification('Erro', errorMsg, 'error');
            console.error('Erro detalhado:', error);
        });
    });
    
    // Função para criar as tabelas de disciplinas
    function criarTabelasDisciplinas(disciplinasPorPeriodo) {
        // Tabela para períodos 1-5
        let html = `
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        ${[1,2,3,4,5].map(p => `<th class="text-center" style="width: 20%">${p}º Período</th>`).join('')}
                    </tr>
                </thead>
                <tbody>
                    <tr style="vertical-align: top;">
                        ${[1,2,3,4,5].map(periodo => {
                            const disciplinasDoPeriodo = disciplinasPorPeriodo[periodo] || [];
                            
                            return `<td style="width: 20%; padding: 15px;">
                                ${disciplinasDoPeriodo.length > 0 
                                    ? disciplinasDoPeriodo.map(d => `
                                        <div class="form-check mb-2">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   name="disciplinas[]" 
                                                   id="disciplina_${d.id}" 
                                                   value="${d.id}"
                                                   data-periodo="${d.periodo}"
                                                   ${d.selecionada ? 'checked' : ''}>
                                            <label for="disciplina_${d.id}" class="form-check-label small">
                                                ${d.nome}
                                            </label>
                                        </div>
                                    `).join('')
                                    : `<div class="text-muted text-center small"><i>Nenhuma disciplina</i></div>`
                                }
                            </td>`;
                        }).join('')}
                    </tr>
                </tbody>
            </table>
            
            <!-- Segunda linha: Períodos 6-10 -->
            <table class="table table-bordered" style="margin-top: 0;">
                <thead class="table-light">
                    <tr>
                        ${[6,7,8,9,10].map(p => `<th class="text-center" style="width: 20%">${p}º Período</th>`).join('')}
                    </tr>
                </thead>
                <tbody>
                    <tr style="vertical-align: top;">${[6,7,8,9,10].map(periodo => {
                            const disciplinasDoPeriodo = disciplinasPorPeriodo[periodo] || [];
                            
                            return `<td style="width: 20%; padding: 15px;">
                                ${disciplinasDoPeriodo.length > 0 
                                    ? disciplinasDoPeriodo.map(d => `
                                        <div class="form-check mb-2">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   name="disciplinas[]" 
                                                   id="disciplina_${d.id}" 
                                                   value="${d.id}"
                                                   data-periodo="${d.periodo}"
                                                   ${d.selecionada ? 'checked' : ''}>
                                            <label for="disciplina_${d.id}" class="form-check-label small">
                                                ${d.nome}
                                            </label>
                                        </div>
                                    `).join('')
                                    : `<div class="text-muted text-center small"><i>Nenhuma disciplina</i></div>`
                                }
                            </td>`;
                        }).join('')}
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
                            <div class="list-group">
                                ${disciplinasPorPeriodo['optativas'] && disciplinasPorPeriodo['optativas'].length > 0 
                                    ? disciplinasPorPeriodo['optativas'].map(d => `
                                        <div class="list-group-item border-0">
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                    class="form-check-input" 
                                                    name="disciplinas[]" 
                                                    id="disciplina_${d.id}" 
                                                    value="${d.id}"
                                                    data-periodo="optativa"
                                                    ${d.selecionada ? 'checked' : ''}>
                                                <label for="disciplina_${d.id}" class="form-check-label small">
                                                    ${d.nome}
                                                </label>
                                            </div>
                                        </div>
                                    `).join('')
                                    : `<div class="col-12 text-muted text-center small"><i>Nenhuma disciplina optativa disponível</i></div>`
                                }
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        `;
        
        return html;
    }
    
    // Configurar handlers para botões de seleção
    function setupSelectionHandlers() {
        const checkboxes = document.querySelectorAll('input[name="disciplinas[]"]');
        
        // Atualizar contador inicialmente
        updateCount();
        
        // Adicionar listeners para cada checkbox
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateCount);
        });
        
        // Desmarcar todas as disciplinas
        unselectAllBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            updateCount();
        });
    }
    
    // Função para atualizar contador
    function updateCount() {
        const checkboxes = document.querySelectorAll('input[name="disciplinas[]"]');
        const selectedCount = document.querySelectorAll('input[name="disciplinas[]"]:checked').length;
        countSelected.textContent = selectedCount + ' disciplina' + (selectedCount !== 1 ? 's' : '') + ' selecionada' + (selectedCount !== 1 ? 's' : '');
    }
    
    // Validação antes de enviar o formulário
    disciplinasForm.addEventListener('submit', function(e) {
        const selectedCount = document.querySelectorAll('input[name="disciplinas[]"]:checked').length;
        if (selectedCount === 0) {
            e.preventDefault();
            showNotification('Erro', 'Por favor, selecione pelo menos uma disciplina.', 'error');
            return;
        }
        
        // Log selected disciplines for debugging
        console.log("Submitting form with the following data:");
        console.log("Ano:", anoHidden.value);
        console.log("Período:", periodoHidden.value);
        console.log("Intenção Matrícula ID:", intencaoMatriculaId.value);
        
        // Log all selected disciplines
        const selectedDisciplines = [];
        document.querySelectorAll('input[name="disciplinas[]"]:checked').forEach(checkbox => {
            selectedDisciplines.push({
                id: checkbox.value,
                periodo: checkbox.dataset.periodo
            });
        });
        console.log("Disciplinas selecionadas:", selectedDisciplines);
    });
});
</script>

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

/* Estilo para notificações flutuantes */
#notifications {
    max-width: 350px;
}

#notifications .toast {
    margin-bottom: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border: none;
}

#notifications .toast-header {
    border-bottom: none;
}

#notifications .btn-close-white {
    filter: brightness(0) invert(1);
}

/* Responsividade para telas menores */
@media (max-width: 768px) {
    .table th, .table td {
        font-size: 0.85rem;
    }
    
    .table-responsive {
        overflow-x: auto; /* Permitir scroll horizontal apenas em telas muito pequenas */
    }
    
    #notifications {
        max-width: 300px;
    }
}
</style>
@endsection
