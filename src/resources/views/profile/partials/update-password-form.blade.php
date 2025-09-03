<section>
    <div class="mb-4">
        <h5 class="mb-3">
            <i class="fas fa-lock"></i> {{ __('Atualizar Senha') }}
        </h5>
        <p class="text-muted small">
            {{ __('Tenha certeza de que a senha utilizada seja longa e aleatória para estar seguro.') }}
        </p>
    </div>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="row">
            <div class="col-12 mb-3">
                <label for="current_password" class="form-label">{{ __('Senha Atual') }} *</label>
                <div class="input-group">
                    <input id="current_password" name="current_password" type="password" 
                           class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                           autocomplete="current-password" placeholder="Digite sua senha atual">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                        <i class="fas fa-eye" id="current_password_icon"></i>
                    </button>
                </div>
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">{{ __('Nova Senha') }} *</label>
                <div class="input-group">
                    <input id="password" name="password" type="password" 
                           class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                           autocomplete="new-password" placeholder="Digite a nova senha">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="password_icon"></i>
                    </button>
                </div>
                @error('password', 'updatePassword')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <div class="form-text">
                    <small>
                        <i class="fas fa-info-circle"></i> 
                        Mínimo 8 caracteres.
                    </small>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="password_confirmation" class="form-label">{{ __('Confirmar Nova Senha') }} *</label>
                <div class="input-group">
                    <input id="password_confirmation" name="password_confirmation" type="password" 
                           class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                           autocomplete="new-password" placeholder="Confirme a nova senha">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                        <i class="fas fa-eye" id="password_confirmation_icon"></i>
                    </button>
                </div>
                @error('password_confirmation', 'updatePassword')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn custom-button">
                <i class="fas fa-shield-alt"></i> {{ __('Atualizar Senha') }}
            </button>

            @if (session('status') === 'password-updated')
                <div class="alert alert-success alert-dismissible fade show mb-0 py-2" role="alert">
                    <small><i class="fas fa-check-circle"></i> {{ __('Senha atualizada com sucesso!') }}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </form>
</section>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
