@extends('layouts.main')
@section('title', 'Visualização de Postagem')
@section('content')

<style>
    :root {
        --navy-primary: #1c2c4c;
        --navy-secondary: #283f6c;
        --blue-medium: #4682b4;
        --blue-light: #6699cc;
        --blue-lighter: #dbe9f6;
        --text-dark: #2c3e50;
        --text-light: #ffffff;
        --accent-color: #28a745;
        --border-radius: 12px;
        --shadow-standard: 0 5px 15px rgba(0, 0, 0, 0.08);
    }
    
    .post-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    
    .post-header {
        margin-bottom: 2rem;
        position: relative;
        padding-bottom: 1rem;
    }
    
    .post-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--navy-primary);
        line-height: 1.2;
        margin-bottom: 1rem;
    }
    
    .post-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .post-date, .post-update {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .post-category {
        display: inline-block;
        background-color: var(--navy-secondary);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .post-cover {
        width: 100%;
        border-radius: var(--border-radius);
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-standard);
    }
    
    .post-cover img {
        width: 100%;
        height: auto;
        display: block;
    }
    
    .post-cover-inner {
        width: 100%;
        margin-bottom: 1.5rem;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        overflow: hidden;
    }
    
    .post-cover-inner img {
        width: 100%;
        height: auto;
        display: block;
    }
    
    .post-cover-divider {
        height: 2px;
        background: linear-gradient(to right, var(--blue-light), var(--navy-primary), var(--blue-light));
        margin: 0 10% 2rem 10%;
        opacity: 0.6;
        border-radius: 1px;
    }
    
    .post-content {
        background-color: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-standard);
    }
    
    .post-text {
        color: var(--text-dark);
        line-height: 1.7;
        font-size: 1.05rem;
    }
    
    .post-text h1 {
        color: var(--navy-primary);
        font-size: 2.2rem;
        font-weight: 700;
        margin: 1.5rem 0 1rem;
    }
    
    .post-text h2 {
        color: var(--navy-secondary);
        font-size: 1.8rem;
        font-weight: 600;
        margin: 1.3rem 0 0.8rem;
    }
    
    .post-text h3 {
        color: var(--blue-medium);
        font-size: 1.5rem;
        font-weight: 600;
        margin: 1.2rem 0 0.7rem;
    }
    
    .post-text p {
        margin-bottom: 1rem;
    }
    
    .post-text ul, .post-text ol {
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .post-text li {
        margin-bottom: 0.5rem;
    }
    
    .post-text a {
        color: var(--blue-medium);
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .post-text a:hover {
        color: var(--navy-primary);
        text-decoration: underline;
    }
    
    /* Barra lateral */
    .post-sidebar {
        margin-top: 3rem;
    }
    
    .sidebar-card {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-standard);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .sidebar-header {
        background-color: var(--navy-primary);
        color: white;
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }
    
    .sidebar-header i {
        color: var(--blue-light);
    }
    
    .sidebar-body {
        padding: 1.5rem;
    }
    
    /* Galeria de imagens */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }
    
    .gallery-item {
        position: relative;
        padding-bottom: 100%;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .gallery-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }
    
    .gallery-item img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Lista de arquivos */
    .file-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .file-item {
        padding: 0.75rem 1rem;
        background-color: var(--blue-lighter);
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: background-color 0.2s ease;
    }
    
    .file-item:hover {
        background-color: rgba(102, 153, 204, 0.2);
    }
    
    .file-icon {
        color: var(--navy-secondary);
        font-size: 1.25rem;
    }
    
    .file-link {
        color: var(--navy-primary);
        text-decoration: none;
        font-weight: 500;
        flex-grow: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .file-link:hover {
        text-decoration: underline;
        color: var(--blue-medium);
    }
    
    /* Botão de voltar */
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: var(--navy-secondary);
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 500;
        margin-top: 1rem;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }
    
    .back-button:hover {
        background-color: var(--navy-primary);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
    
    .empty-state {
        padding: 1.5rem;
        text-align: center;
        color: #6c757d;
        font-style: italic;
    }
    
    /* Responsividade */
    @media (max-width: 992px) {
        .post-sidebar {
            margin-top: 2rem;
        }
        
        .post-title {
            font-size: 2.2rem;
        }
    }
    
    @media (max-width: 768px) {
        .post-title {
            font-size: 1.8rem;
        }
        
        .post-content {
            padding: 1.5rem;
        }
        
        .post-text {
            font-size: 1rem;
        }
        
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 576px) {
        .post-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .post-title {
            font-size: 1.6rem;
        }
        
        .post-content {
            padding: 1.2rem;
        }
    }
</style>

<div class="post-container">
    <a href="{{ url()->previous() }}" class="back-button">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
    
    <div class="row mt-4">
        <div class="col-lg-8">
            <article>
                <!-- Post header -->
                <div class="post-header">
                    <h1 class="post-title">{{ $postagem->titulo }}</h1>
                    <div class="post-meta">
                        <div class="post-date">
                            <i class="far fa-calendar-alt"></i>
                            Publicado em {{ \Carbon\Carbon::parse($postagem->created_at)->isoFormat('DD [de] MMMM [de] YYYY, HH[h]mm') }}
                        </div>
                        <div class="post-update">
                            <i class="far fa-clock"></i>
                            Atualizado em {{ \Carbon\Carbon::parse($postagem->updated_at)->isoFormat('DD [de] MMMM [de] YYYY, HH[h]mm') }}
                        </div>
                        <span class="post-category">{{ $tipo_postagem->nome }}</span>
                    </div>
                </div>

                <!-- Post content with cover image -->
                <div class="post-content">
                    @if ($postagem->menu_inicial)
                    @php $capa = $postagem->capa; @endphp
                    @if (Storage::disk('public')->exists($capa->imagem))
                    <div class="post-cover-inner">
                        <img src="{{ URL::asset('storage') }}/{{ $capa->imagem }}" alt="{{ $postagem->titulo }}">
                    </div>
                    <div class="post-cover-divider"></div>
                    @endif
                    @endif
                    
                    <div class="post-text">{!! $postagem->texto !!}</div>
                </div>
                
                @auth
                <!-- Seção de Comentários -->
                <div class="sidebar-card mt-3">
                    <div class="sidebar-header">
                        <i class="fas fa-comments"></i> Comentários ({{ $postagem->comentarios->count() }})
                    </div>
                    <div class="sidebar-body">
                        <!-- Mensagem quando não há comentários -->
                        @if($postagem->comentarios->count() === 0)
                            <div class="empty-state text-center py-4">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Ainda não há comentários nesta postagem.</p>
                                <small class="text-muted">Seja o primeiro a comentar!</small>
                            </div>
                        @endif

                        <!-- Formulário para Novo Comentário -->
                        <div class="comment-form-container mb-4">
                            <form id="comentario-form" method="POST" action="{{ route('comentarios.store') }}">
                                @csrf
                                <input type="hidden" name="postagem_id" value="{{ $postagem->id }}">
                                <div class="mb-3">
                                    <label for="conteudo" class="form-label fw-bold">
                                        <i class="fas fa-edit"></i> Adicionar comentário:
                                    </label>
                                    <textarea 
                                        class="form-control form-control-lg border-2" 
                                        id="conteudo" 
                                        name="conteudo" 
                                        rows="4" 
                                        maxlength="1000" 
                                        placeholder="Compartilhe sua opinião sobre esta postagem..."
                                        style="resize: vertical; min-height: 100px;"
                                        required></textarea>
                                    <div class="d-flex justify-content-end mt-1">
                                        <small class="text-muted fw-bold">
                                            <span id="char-count">0</span>/1000
                                        </small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-user-circle text-primary"></i> Comentando como <strong>{{ auth()->user()->name }}</strong>
                                    </small>
                                    <button type="submit" class="btn btn-primary btn-lg px-4">
                                        <i class="fas fa-paper-plane me-2"></i> Enviar Comentário
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Lista de Comentários -->
                        @if($postagem->comentarios->count() > 0)
                            <div id="comentarios-lista">
                                <hr class="my-4">
                                <h6 class="text-muted mb-3">
                                    <i class="fas fa-comments me-2"></i>
                                    Todos os comentários
                                </h6>
                                @foreach($postagem->comentarios as $comentario)
                                    <div class="comentario-item mb-4 p-3 bg-light rounded border-start border-primary border-4" data-id="{{ $comentario->id }}">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="comentario-header">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-user-circle text-primary me-2 fa-lg"></i>
                                                    <strong class="text-dark">{{ $comentario->user->name }}</strong>
                                                    <small class="text-muted ms-2">
                                                        {{ $comentario->created_at->format('d/m/Y H:i') }}
                                                        @if($comentario->foiEditado())
                                                            <span class="badge bg-secondary ms-1">
                                                                <i class="fas fa-edit"></i> Editado
                                                            </span>
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                            @if(auth()->user() && (auth()->user()->id === $comentario->user_id || auth()->user()->hasRole('coordenador')))
                                                <div class="comentario-actions">
                                                    @if(auth()->user()->id === $comentario->user_id)
                                                    <button class="btn btn-sm btn-outline-primary me-1" 
                                                            onclick="editarComentario({{ $comentario->id }}, '{{ addslashes($comentario->conteudo) }}')"
                                                            title="Editar comentário">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @endif
                                                    <form method="POST" action="{{ route('comentarios.destroy', $comentario->id) }}" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                onclick="return confirm('Tem certeza que deseja deletar este comentário?')"
                                                                title="Excluir comentário">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="comentario-conteudo" id="comentario-{{ $comentario->id }}">
                                            <p class="mb-0 text-dark">{{ $comentario->conteudo }}</p>
                                        </div>
                                        
                                        <!-- Formulário de edição (oculto) -->
                                        <div class="comentario-edit-form mt-2" id="edit-form-{{ $comentario->id }}" style="display: none;">
                                            <form method="POST" action="{{ route('comentarios.update', $comentario->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <textarea name="conteudo" 
                                                              class="form-control edit-textarea" 
                                                              rows="3" 
                                                              required 
                                                              maxlength="1000"
                                                              data-comment-id="{{ $comentario->id }}">{{ $comentario->conteudo }}</textarea>
                                                    <div class="d-flex justify-content-end mt-1">
                                                        <small class="text-muted fw-bold">
                                                            <span id="edit-char-count-{{ $comentario->id }}">{{ strlen($comentario->conteudo) }}</span>/1000
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-save"></i> Salvar
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-secondary btn-sm" 
                                                            onclick="cancelarEdicao({{ $comentario->id }})">
                                                        <i class="fas fa-times"></i> Cancelar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                @else
                <div class="sidebar-card mt-3">
                    <div class="sidebar-body text-center py-5">
                        <i class="fas fa-sign-in-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Faça login para interagir</h5>
                        <p class="text-muted mb-3">Para comentar e favoritar esta postagem, você precisa estar logado.</p>
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Fazer Login
                        </a>
                    </div>
                </div>
                @endauth
            </article>
        </div>
        
        <div class="col-lg-4">
            <div class="post-sidebar">
                <!-- Images gallery -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <i class="far fa-images"></i> Galeria de Imagens
                    </div>
                    <div class="sidebar-body">
                        @if (count($postagem->imagens) > 0)
                        <div class="gallery-grid">
                            @foreach ($postagem->imagens as $imagem)
                            @if (Storage::disk('public')->exists($imagem->imagem))
                            <a class="gallery-item" href="{{ URL::asset('storage') }}/{{ $imagem->imagem }}" target="_blank">
                                <img src="{{ URL::asset('storage') }}/{{ $imagem->imagem }}" alt="{{ $postagem->titulo }}">
                            </a>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <div class="empty-state">Nenhuma imagem disponível</div>
                        @endif
                    </div>
                </div>
                
                <!-- File attachments -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <i class="far fa-file-alt"></i> Arquivos
                    </div>
                    <div class="sidebar-body">
                        @if (count($postagem->arquivos) > 0)
                        <div class="file-list">
                            @foreach ($postagem->arquivos as $arquivo)
                            <div class="file-item">
                                <div class="file-icon">
                                    <i class="far fa-file"></i>
                                </div>
                                <a class="file-link" href="{{ URL::asset('storage') }}/{{ $arquivo->path }}" target="_blank" title="Arquivo">
                                    {{ $arquivo->nome }}
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="empty-state">Nenhum arquivo disponível</div>
                        @endif
                    </div>
                </div>

                @auth
                <!-- Botão de Favoritar -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <i class="fas fa-heart"></i> Favoritar Postagem
                    </div>
                    <div class="sidebar-body text-center">
                        <form method="POST" action="{{ route('favoritos.toggle') }}" id="favoritoForm">
                            @csrf
                            <input type="hidden" name="type" value="postagem">
                            <input type="hidden" name="id" value="{{ $postagem->id }}">
                            <button type="submit" 
                                    class="btn {{ Auth::user()->jaFavoritou($postagem) ? 'btn-danger' : 'btn-outline-danger' }} btn-lg w-100 mb-3">
                                <i class="fas fa-heart"></i>
                                {{ Auth::user()->jaFavoritou($postagem) ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos' }}
                            </button>
                        </form>
                        <small class="text-muted">
                            <i class="fas fa-heart text-danger"></i> {{ $postagem->totalFavoritos() }} pessoa(s) favoritaram esta postagem
                        </small>
                    </div>
                </div>
                
                <!-- Botão Meus Favoritos -->
                <div class="sidebar-card">
                    <div class="sidebar-body text-center">
                        <a href="{{ route('favoritos.meus') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="fas fa-star me-2"></i>Ver Meus Favoritos
                        </a>
                        <small class="text-muted d-block mt-2">Acesse todas as suas postagens e TCCs favoritos</small>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Seção de Favoritos -->
    <div class="row mt-2">
        <div class="col-lg-8">
        </div>
        
        <div class="col-lg-4">
            <div class="post-sidebar">
            </div>
        </div>
    </div>
</div>

<script>
    // Contador de caracteres em tempo real
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('conteudo');
        const charCount = document.getElementById('char-count');
        
        if (textarea && charCount) {
            textarea.addEventListener('input', function() {
                const currentLength = this.value.length;
                charCount.textContent = currentLength;
                
                // Mudança de cor baseada na quantidade de caracteres
                if (currentLength > 900) {
                    charCount.style.color = '#dc3545'; // Vermelho
                } else if (currentLength > 700) {
                    charCount.style.color = '#fd7e14'; // Laranja
                } else {
                    charCount.style.color = '#6c757d'; // Cinza normal
                }
            });
        }

        // Contador para formulários de edição
        const editTextareas = document.querySelectorAll('.edit-textarea');
        editTextareas.forEach(function(textarea) {
            textarea.addEventListener('input', function() {
                const commentId = this.getAttribute('data-comment-id');
                const charCountElement = document.getElementById('edit-char-count-' + commentId);
                
                if (charCountElement) {
                    const currentLength = this.value.length;
                    charCountElement.textContent = currentLength;
                    
                    // Mudança de cor baseada na quantidade de caracteres
                    if (currentLength > 900) {
                        charCountElement.style.color = '#dc3545'; // Vermelho
                    } else if (currentLength > 700) {
                        charCountElement.style.color = '#fd7e14'; // Laranja
                    } else {
                        charCountElement.style.color = '#6c757d'; // Cinza normal
                    }
                }
            });
        });
    });
    
    function editarComentario(id, conteudo) {
        // Ocultar o conteúdo original
        document.getElementById('comentario-' + id).style.display = 'none';
        // Mostrar o formulário de edição
        document.getElementById('edit-form-' + id).style.display = 'block';
    }
    
    function cancelarEdicao(id) {
        // Mostrar o conteúdo original
        document.getElementById('comentario-' + id).style.display = 'block';
        // Ocultar o formulário de edição
        document.getElementById('edit-form-' + id).style.display = 'none';
    }
    
    // Modal para imagens
    document.addEventListener('DOMContentLoaded', function() {
        // Criar modal para visualização de imagens
        const modalHTML = `
            <div id="image-viewer-modal" class="image-modal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); justify-content: center; align-items: center;">
                <img id="modal-image-content" class="image-modal-content" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                <span class="close-modal" style="position: absolute; top: 15px; right: 35px; color: #f1f1f1; font-size: 40px; font-weight: bold; cursor: pointer;">&times;</span>
            </div>
        `;
        
        // Adicionar modal ao body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        const modal = document.getElementById('image-viewer-modal');
        const modalImg = document.getElementById('modal-image-content');
        const closeBtn = modal.querySelector('.close-modal');
        
        // Fechar modal quando clicar no X ou fora da imagem
        modal.addEventListener('click', function(e) {
            if (e.target === modal || e.target === closeBtn) {
                modal.style.display = 'none';
            }
        });
        
        // Adicionar evento de clique para as imagens da galeria
        const galleryItems = document.querySelectorAll('.gallery-item');
        galleryItems.forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const imgSrc = this.getAttribute('href');
                modalImg.src = imgSrc;
                modal.style.display = 'flex';
            });
        });
    });
</script>

@endsection
