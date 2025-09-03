<!-- Modal de Confirmação de Exclusão Genérico -->
<div class="modal fade" id="confirmDeleteGenericModal" tabindex="-1" aria-labelledby="confirmDeleteGenericModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteGenericModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                </div>
                <h6 class="mb-3" id="deleteMessage">Tem certeza que deseja excluir este registro?</h6>
                <p class="text-muted mb-0">
                    <strong id="recordInfo"></strong>
                </p>
                <p class="text-muted small">
                    Esta ação não pode ser desfeita.
                </p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteGenericBtn">
                    <i class="fas fa-trash me-1"></i>
                    Sim, Excluir
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let deleteFormGeneric = null;

function confirmDeleteGeneric(form, message = 'Tem certeza que deseja excluir este registro?', info = '') {
    deleteFormGeneric = form;
    document.getElementById('deleteMessage').textContent = message;
    document.getElementById('recordInfo').textContent = info;
    const modal = new bootstrap.Modal(document.getElementById('confirmDeleteGenericModal'));
    modal.show();
}

document.getElementById('confirmDeleteGenericBtn').addEventListener('click', function() {
    if (deleteFormGeneric) {
        deleteFormGeneric.submit();
    }
});
</script>
