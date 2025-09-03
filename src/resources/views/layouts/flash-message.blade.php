<div class="alert-container">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="alert-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="alert-content">
            <div class="alert-title">Sucesso!</div>
            <p class="alert-message">{{ session('success') }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="alert-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="alert-content">
            <div class="alert-title">Erro!</div>
            <p class="alert-message">{{ session('error') }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if (session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <div class="alert-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="alert-content">
            <div class="alert-title">Atenção!</div>
            <p class="alert-message">{{ session('warning') }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if (session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <div class="alert-icon">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="alert-content">
            <div class="alert-title">Informação</div>
            <p class="alert-message">{{ session('info') }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
    @endif
</div>

{{-- JavaScript notifications to avoid duplicates --}}
@if (session('js_alert'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const alertData = @json(session('js_alert'));
    
    if (typeof window[`show${alertData.type.charAt(0).toUpperCase()}${alertData.type.slice(1)}Message`] === 'function') {
        window[`show${alertData.type.charAt(0).toUpperCase()}${alertData.type.slice(1)}Message`](alertData.message);
    } else {
        // Fallback for missing function types
        if (typeof showSuccessMessage === 'function') {
            showSuccessMessage(alertData.message, alertData.type.charAt(0).toUpperCase() + alertData.type.slice(1) + '!');
        }
    }
});
</script>
@endif

@if (session('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <div class="alert-icon">
        <i class="fas fa-exclamation-triangle"></i>
    </div>
    <div class="alert-content">
        <div class="alert-title">Atenção!</div>
        <p class="alert-message">{{ session('warning') }}</p>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
@endif

@if (session('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <div class="alert-icon">
        <i class="fas fa-info-circle"></i>
    </div>
    <div class="alert-content">
        <div class="alert-title">Informação</div>
        <p class="alert-message">{{ session('info') }}</p>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
@endif
