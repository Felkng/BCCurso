<section>
    <div class="mb-4">
        <h5 class="mb-3">
            <i class="fas fa-user-circle"></i> {{ __('Informações da Conta') }}
        </h5>
        <p class="text-muted small">
            {{ __("Atualize seu nome de perfil e o endereço de email.") }}
        </p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">{{ __('Nome') }} *</label>
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">{{ __('Email') }} *</label>
                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="alert alert-warning mt-2">
                        <small>
                            {{ __('Seu email não é verificado.') }}
                            <button form="send-verification" class="btn btn-link p-0 text-decoration-underline">
                                {{ __('Clique aqui para reenviar o email de verificação.') }}
                            </button>
                        </small>

                        @if (session('status') === 'verification-link-sent')
                            <div class="text-success small mt-1">
                                {{ __('Um novo link de verificação foi enviado para seu endereço de email.') }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            @if($aluno)
            <div class="col-md-6 mb-3">
                <label for="matricula" class="form-label">{{ __('Matrícula') }}</label>
                <input id="matricula" name="matricula" type="text" class="form-control" 
                       value="{{ $aluno->matricula }}" readonly disabled>
                <div class="form-text">Esta informação não pode ser alterada.</div>
            </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn custom-button">
                <i class="fas fa-save"></i> {{ __('Salvar') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show mb-0 py-2" role="alert">
                    <small><i class="fas fa-check-circle"></i> {{ __('Perfil atualizado com sucesso!') }}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </form>
</section>
