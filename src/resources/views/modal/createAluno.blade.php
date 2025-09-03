<div class="modal fade" id="createAluno" tabindex="-1" aria-labelledby="createAlunoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title" id="createAlunoLabel">
                    <i class="fas fa-user-plus"></i> Cadastrar Novo Aluno
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modal_aluno_success" class="alert alert-success rounded-3" style="display:none;"></div>
                <div id="modal_aluno_errors" class="alert alert-danger rounded-3" style="display:none;"></div>

                <form id="form_create_aluno_modal" method="post" action="{{ route('aluno.store') }}">
                    @csrf
                    <input type="hidden" name="contexto" value="modal">
                    <div class="mb-3">
                        <label for="modal_aluno_nome" class="form-label">Nome*:</label>
                        <input type="text" name="nome" id="modal_aluno_nome" class="form-control"
                            placeholder="Nome completo do aluno" required>
                    </div>
                    <div class="mb-3">
                        <label for="modal_aluno_email" class="form-label">Email*:</label>
                        <input type="email" name="email" id="modal_aluno_email" class="form-control"
                            placeholder="melhor@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="modal_aluno_matricula" class="form-label">Matrícula*:</label>
                        <input type="text" name="matricula" id="modal_aluno_matricula" class="form-control"
                            placeholder="Número da matrícula" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="submit_button_aluno"
                    form="form_create_aluno_modal">Cadastrar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#form_create_aluno_modal').on('submit', function(event) {
        event.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();
        var submitButton = $('#submit_button_aluno');

        submitButton.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cadastrando...'
            );
        $('#modal_aluno_errors').hide();
        $('#modal_aluno_success').hide();

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function(response) {
                if (response && response.success) {
                    // Feche o modal
                    $('#createAluno').modal('hide');
                    
                    // Limpe o formulário
                    $('#form_create_aluno_modal')[0].reset();
                    
                    // Mostra notificação de sucesso
                    showSuccessMessage('Aluno cadastrado com sucesso!');

                    $('#aluno_id').append(new Option(response.aluno.nome, response.aluno.id,
                        true, true)).trigger('change');
                    

                } else {
                    showErrorMessage('A resposta do servidor não indicou sucesso.');
                }
            },
            error: function(jqXHR) {
                var errorMessage = '';
                if (jqXHR.status === 422) {
                    var errors = jqXHR.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        errorMessage += value + '<br>';
                    });
                    showErrorMessage(errorMessage, 'Erro de Validação');
                } else {
                    var serverMessage = 'Por favor, tente novamente.';
                    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                        serverMessage = jqXHR.responseJSON.message;
                    }
                    showErrorMessage('Ocorreu um erro inesperado. ' + serverMessage);
                }
            },
            complete: function() {
                submitButton.prop('disabled', false).html('Cadastrar');
            }
        });
    });

    $('#createAluno').on('hidden.bs.modal', function() {
        $('#modal_aluno_errors').hide();
        $('#modal_aluno_success').hide();
        $('#form_create_aluno_modal').trigger('reset').show();
        $('#createAluno .modal-footer').show();
        
        // Fix para restaurar o scroll da página
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $('body').css('padding-right', '');
        $('body').css('overflow', '');
    });
});
</script>