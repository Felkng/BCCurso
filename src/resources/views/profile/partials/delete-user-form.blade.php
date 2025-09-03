<section>
    <div class="mb-4">
        <h5 class="mb-3 text-danger">
            <i class="fas fa-exclamation-triangle"></i> {{ __('Excluir Conta') }}
        </h5>

        <p class="text-muted small mb-0">
            {{ __('Esta ação é irreversível. Clique no botão abaixo apenas se você realmente deseja excluir sua conta.') }}
        </p>

    </div>

    <!-- Botão para abrir modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
        <i class="fas fa-trash"></i> {{ __('Excluir Conta') }}
    </button>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">
                        <i class="fas fa-exclamation-triangle"></i> {{ __('Confirmar Exclusão') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    
                    <div class="modal-body">
                        <h6 class="text-danger mb-3">
                            {{ __('Você tem certeza que deseja excluir esta conta?') }}
                        </h6>

                        <p class="text-muted">
                            {{ __('Ao excluir sua conta, todos os seus recursos e dados serão permanentemente excluídos. Por favor insira a sua senha para confirmar que deseja permanentemente excluir sua conta.') }}
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Senha') }} *</label>
                            <input id="password" name="password" type="password" 
                                   class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                   placeholder="{{ __('Digite sua senha para confirmar') }}" required>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> {{ __('Cancelar') }}
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> {{ __('Excluir Conta Permanentemente') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@if($errors->userDeletion->isNotEmpty())
<script>
    // Se houver erros de validação, abrir o modal automaticamente
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    });
</script>
@endif
