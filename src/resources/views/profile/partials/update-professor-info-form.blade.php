<section>
    <div class="mb-4">
        <h5 class="mb-3">
            <i class="fas fa-chalkboard-teacher"></i> {{ __('Informações do Professor') }}
        </h5>
        <p class="text-muted small">
            {{ __("Atualize os seus dados de professor.") }}
        </p>
    </div>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="titulacao" class="form-label">{{ __('Titulação') }}</label>
                <input id="titulacao" name="titulacao" type="text" class="form-control @error('titulacao') is-invalid @enderror" 
                       value="{{ old('titulacao', $professor->titulacao ?? '') }}" autocomplete="titulacao">
                @error('titulacao')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-8 mb-3">
                <label for="area" class="form-label">{{ __('Área de Atuação') }}</label>
                <input id="area" name="area" type="text" class="form-control @error('area') is-invalid @enderror" 
                       value="{{ old('area', $professor->area ?? '') }}" autocomplete="area">
                @error('area')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="biografia" class="form-label">{{ __('Biografia') }}</label>
            <textarea id="biografia" name="biografia" class="form-control @error('biografia') is-invalid @enderror" 
                      rows="8" maxlength="5000" 
                      placeholder="Descreva sua biografia profissional (máximo 5000 caracteres)">{{ old('biografia', $professor->biografia ?? '') }}</textarea>
            <div class="form-text">
                <small class="text-muted">
                    <span id="biografia-counter">0</span>/5000 caracteres
                </small>
            </div>
            @error('biografia')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Links -->
        <div class="mb-4">
            <label class="form-label">{{ __('Links Úteis') }}</label>
            <div id="links-container">
                @if($professor && $professor->curriculos->first())
                    @forelse ($professor->curriculos->first()->links as $link)
                        <div class="link-input-group mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" name="links[{{ $link->id }}]" value="{{ $link->link }}" placeholder="https://exemplo.com">
                                <button type="button" class="btn btn-outline-danger delete-link-btn" data-id="{{ $link->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                    @endforelse
                @endif
            </div>
            
            <div id="new-links-container">  
                @foreach (old('new_links', []) as $index => $oldLinkUrl)
                    <div class="link-input-group-new mb-2">
                        <div class="input-group">
                            <input type="text" class="form-control @error('new_links.'.$index) is-invalid @enderror" 
                                   name="new_links[]" value="{{ $oldLinkUrl }}" placeholder="https://novo-link.com">
                            <button type="button" class="btn btn-outline-danger remove-new-link-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        @error('new_links.'.$index)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>
            
            <button type="button" id="add-link-btn" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-plus"></i> Adicionar Link
            </button>
        </div>

        <!-- Foto -->
        <div class="mb-4">
            <label for="fotos" class="form-label">{{ __('Foto de Perfil') }}</label>
            
            @if (count($user->fotos) > 0)
                <div class="row mb-3">
                    @foreach ($user->fotos as $ft)
                        <div class="col-auto mb-2">
                            <div class="profile-photo-container">
                                <img src="{{ URL::asset('storage') }}/{{ $ft->foto }}" 
                                     class="img-thumbnail" style="max-height:120px; max-width:120px; object-fit: cover;">
                                <button type="submit" form="deletar-fotos{{ $ft->id }}" 
                                        class="btn btn-danger btn-sm remove-photo-btn"
                                        title="Remover foto"
                                        onclick="return confirm('Tem certeza que deseja remover esta foto?')">
                                    <i class="fas fa-times" style="font-size: 11px;"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            
            <input type="file" name="fotos[]" id="fotos" class="form-control" multiple accept="image/*">
            <div class="form-text">
                <i class="fas fa-info-circle"></i> Você pode selecionar múltiplas imagens. 
                Formatos aceitos: JPG, PNG, GIF (máx. 2MB cada).
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn custom-button">
                <i class="fas fa-save"></i> {{ __('Salvar') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show mb-0 py-2" role="alert">
                    <small><i class="fas fa-check-circle"></i> {{ __('Salvo com sucesso!') }}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </form>
    
    @if (count($user->fotos) > 0)
        @foreach ($user->fotos as $ft)
            <form id="deletar-fotos{{ $ft->id }}"
                action="{{ route('profile.delete_foto', ['id' => $ft->id]) }}" method="post">
                @csrf
                @method('delete')
            </form>
        @endforeach
    @endif
</section>

<!-- Script para gerenciar links -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Adicionar novo link
    document.getElementById('add-link-btn').addEventListener('click', function () {
        const container = document.getElementById('new-links-container');
        const newLinkGroupHTML = `
            <div class="link-input-group-new mb-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="new_links[]" placeholder="https://novo-link.com">
                    <button type="button" class="btn btn-outline-danger remove-new-link-btn">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newLinkGroupHTML);
    });

    // Event delegation para botões de exclusão
    document.querySelector('body').addEventListener('click', async function(event) {
        // Deletar link existente
        if (event.target.closest('.delete-link-btn')) {
            const button = event.target.closest('.delete-link-btn');
            const linkId = button.dataset.id;
            
            if (!confirm('Tem certeza que deseja excluir este link permanentemente?')) return;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const response = await fetch(`/links/${linkId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    button.closest('.link-input-group').remove();
                } else {
                    alert('Erro ao excluir: ' + (data.message || 'Tente novamente.'));
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Ocorreu um erro de comunicação.');
            }
        }

        // Remover novo link (ainda não salvo)
        if (event.target.closest('.remove-new-link-btn')) {
            event.target.closest('.link-input-group-new').remove();
        }
    });

    // Contador de caracteres para biografia
    const biografiaTextarea = document.getElementById('biografia');
    const biografiaCounter = document.getElementById('biografia-counter');
    
    function updateBiografiaCounter() {
        const currentLength = biografiaTextarea.value.length;
        biografiaCounter.textContent = currentLength;
        
        // Muda cor do contador conforme aproxima do limite
        if (currentLength > 4500) {
            biografiaCounter.style.color = '#dc3545'; // vermelho
        } else if (currentLength > 4000) {
            biografiaCounter.style.color = '#fd7e14'; // laranja
        } else {
            biografiaCounter.style.color = '#6c757d'; // cinza padrão
        }
    }
    
    // Atualiza contador ao carregar a página
    updateBiografiaCounter();
    
    // Atualiza contador quando o usuário digita
    biografiaTextarea.addEventListener('input', updateBiografiaCounter);
});
</script>
