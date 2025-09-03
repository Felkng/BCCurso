<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="modal fade" id="createProfessorExterno" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cadastrar professor externo</h5>
                <button type="button" class="close btn btn-lg" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome-professor-externo" id="nome-professor-externo" class="form-control" placeholder="Nome do professor externo">
                    <label for="filiacao-professor-externo">Filiação</label>
                    <input type="text" name="filiacao" id="filiacao-professor-externo" class="form-control" placeholder="Nome da instituição de filiação">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn custom-button" data-dismiss="modal" id="cadastrarProfessoExternoButton">Cadastrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var isProcessing = false; 

        $('#cadastrarProfessoExternoButton').click(function() {
            if (isProcessing) {
                return;
            }

            var nome = $('#nome-professor-externo').val();
            var filiacao = $('#filiacao-professor-externo').val();

            if (nome.trim() === '' || filiacao.trim() === '') {
                alert('Por favor, preencha todos os campos.');
                return;
            }

            isProcessing = true;
            var $button = $(this);
            var originalText = $button.text();
            $button.prop('disabled', true).text('Cadastrando...');

            var professoresSelecionadosAntes = [];
            $('input[name="professores_externos[]"]:checked').each(function() {
                professoresSelecionadosAntes.push($(this).val());
            });

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            var data = {
                _token: csrfToken,
                nome: nome,
                filiacao: filiacao,
                contexto: 'modal'
            };

            $.ajax({
                type: 'POST',
                url: "{{ route('professor-externo.store') }}",
                data: data,
                success: function(response) {
                    if (response.error) {
                        showErrorMessage(response.error);
                    } else {
                        $('#createProfessorExterno').modal('hide');

                        $('#nome-professor-externo').val('');
                        $('#filiacao-professor-externo').val('');

                        var professor = response.professor_externo;
                        var novoProfessorHtml = '<div class="form-check d-flex align-items-center" id="professor_externo_container_' + professor.id + '">' +
                            '<input type="checkbox" class="form-check-input me-2" name="professores_externos[]" ' +
                            'id="professor_externo_' + professor.id + '" value="' + professor.id + '">' +
                            '<label for="professor_externo_' + professor.id + '" class="form-check-label text-wrap flex-grow-1">' +
                            professor.nome + ' - ' + professor.filiacao + '</label>' +
                            '<button type="button" class="btn btn-sm btn-outline-danger ms-2 delete-professor-externo" ' +
                            'data-professor-id="' + professor.id + '" ' +
                            'data-professor-nome="' + professor.nome + '" ' +
                            'title="Excluir professor externo">' +
                            '<i class="fas fa-times"></i>' +
                            '</button>' +
                            '</div>';
                        
                        $('#professores_externos').append(novoProfessorHtml);
                        
                        $('#professor_externo_' + professor.id).prop('checked', true);

                        var returnToModalSelector = $('#cadastrarProfessorExternoModal').data('return-to-modal');
                        if (returnToModalSelector) {
                            setTimeout(function() {
                                $(returnToModalSelector).modal('show');
                            }, 300);
                        }
                        setTimeout(function() {
                            if (typeof showSuccessMessage === 'function') {
                                var mensagem = response.mensagem || 'Professor externo cadastrado com sucesso!';
                                showSuccessMessage(mensagem);
                            } else {
                                alert('Professor externo cadastrado com sucesso!');
                            }
                        }, 500);
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        for (var field in errors) {
                            errorMessage += errors[field][0] + '<br>';
                        }
                        showErrorMessage(errorMessage, 'Erro de Validação');
                    } else {
                        showErrorMessage('Erro ao cadastrar professor externo. Tente novamente.');
                    }
                },
                complete: function() {
                    isProcessing = false;
                    $button.prop('disabled', false).text(originalText);
                }
            });
        });

        $('#createProfessorExterno').on('hidden.bs.modal', function () {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('body').css('padding-right', '');
            $('body').css('overflow', '');
        });
        
        // Função auxiliar para mostrar erros (caso não exista)
        if (typeof showErrorMessage !== 'function') {
            window.showErrorMessage = function(message, title = 'Erro') {
                alert(title + ': ' + message);
            };
        }
    });
</script>
