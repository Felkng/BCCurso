@extends('layouts.main')
@section('title', 'Ciência da Computação')
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
    }
    
    .page-heading {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--navy-primary);
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.8rem;
    }
    
    .page-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 4px;
        background: var(--blue-medium);
        border-radius: 2px;
    }
    
    .section-heading {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--navy-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    
    .section-heading i {
        color: var(--blue-medium);
    }
    
    .featured-carousel {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        border: 2px solid rgba(70, 130, 180, 0.15);
        margin-bottom: 3rem;
    }
    
    .carousel-inner {
        border-radius: 12px;
    }
    
    .carousel-item {
        height: 400px;
        position: relative;
    }
    
    .carousel-item img {
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
    
    .carousel-caption {
        background: linear-gradient(0deg, rgba(28, 44, 76, 0.9) 0%, rgba(28, 44, 76, 0) 100%);
        left: 0;
        right: 0;
        bottom: 0;
        padding: 2rem 1.5rem;
        text-align: left;
    }
    
    .carousel-indicators {
        margin-bottom: 1rem;
    }
    
    .carousel-indicators [data-bs-target] {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        border: none;
        margin: 0 6px;
    }
    
    .carousel-indicators .active {
        background-color: var(--text-light);
        transform: scale(1.2);
    }
    
    .posts-grid {
        margin-top: 2rem;
    }
    
    .post-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: none;
        background-color: var(--text-light);
        display: flex;
        flex-direction: column;
        min-height: 350px; /* Altura mínima para todos os cards */
    }
    
    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }
    
    .post-img-container {
        width: 100%;
        position: relative;
        overflow: hidden;
        padding-top: 150px;
    }
    
    .post-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .post-card:hover .post-img {
        transform: scale(1.02);
    }
    
    .post-content {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    
    .post-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--navy-primary);
        margin-bottom: 0.8rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 3em;
    }
    
    .post-meta {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .post-date {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .post-btn {
        padding: 0.4rem 1rem;
        background-color: var(--navy-primary);
        color: var(--text-light);
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        border: none;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .post-btn:hover {
        background-color: var(--blue-medium);
        color: var(--text-light);
    }
    
    .post-btn i {
        font-size: 0.8rem;
    }
    
    .pagination-container {
        margin: 3rem 0;
    }
    
    .pagination {
        justify-content: center;
    }
    
    .page-item.active .page-link {
        background-color: var(--navy-primary);
        border-color: var(--navy-primary);
        color: var(--text-light);
        font-weight: 500;
    }
    
    .page-link {
        color: var(--navy-secondary);
        border: 1px solid #e9ecef;
        padding: 0.5rem 0.9rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    
    .page-link:hover {
        background-color: var(--blue-lighter);
        color: var(--navy-primary);
        border-color: var(--blue-light);
    }
    
    .pagination-text {
        text-align: center;
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 1rem;
    }
    
    /* Search Component Styles - Inline Version com design completo */
    .search-container-inline {
        display: flex;
        align-items: center;
    }
    
    .search-form-inline {
        display: flex;
        align-items: stretch;
        box-shadow: 0 8px 25px rgba(28, 44, 76, 0.1);
        border-radius: 50px;
        background: white;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        overflow: hidden;
        min-width: 320px;
    }
    
    .search-form-inline:focus-within {
        border-color: var(--blue-light);
        box-shadow: 0 8px 30px rgba(70, 130, 180, 0.2);
        transform: translateY(-2px);
    }
    
    .search-input-wrapper-inline {
        flex: 1;
        display: flex;
        align-items: center;
        position: relative;
        padding: 0 1.2rem;
        background: white;
        border-radius: 50px 0 0 50px;
        cursor: text;
    }
    
    .search-icon-inline {
        color: var(--blue-medium);
        font-size: 1rem;
        margin-right: 0.6rem;
        opacity: 0.7;
        pointer-events: none;
        flex-shrink: 0;
    }
    
    .search-input-inline {
        flex: 1;
        border: none;
        outline: none;
        font-size: 0.95rem;
        padding: 0.8rem 0;
        color: var(--text-dark);
        background: transparent;
        width: 100%;
        min-width: 0;
    }
    
    .search-input-inline:focus {
        outline: none !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    .search-input-inline::placeholder {
        color: #9ca3af;
        font-weight: 400;
    }
    
    .clear-search-inline {
        color: #9ca3af;
        text-decoration: none;
        padding: 0.3rem;
        border-radius: 50%;
        transition: all 0.2s ease;
        margin-left: 0.4rem;
        flex-shrink: 0;
    }
    
    .clear-search-inline:hover {
        color: #ef4444;
        background: rgba(239, 68, 68, 0.1);
    }
    
    .search-btn-inline {
        background: var(--navy-primary);
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        border-radius: 0 50px 50px 0;
        flex-shrink: 0;
    }
    
    .search-btn-inline:hover {
        background: var(--blue-medium);
        transform: translateX(2px);
    }
    
    .search-btn-inline:active {
        transform: translateX(1px);
        background: var(--navy-secondary);
    }
    
    .search-btn-inline span {
        font-weight: 500;
    }
    
    .search-results-info-inline {
        padding: 0.8rem 1.2rem;
        background: rgba(70, 130, 180, 0.1);
        border-radius: 12px;
        color: var(--navy-secondary);
        font-size: 0.9rem;
        text-align: center;
        border-left: 4px solid var(--blue-medium);
    }
    
    .search-results-info-inline i {
        color: var(--blue-medium);
        margin-right: 0.5rem;
    }
    
    .results-count {
        color: #6c757d;
        font-size: 0.85rem;
        margin-left: 0.5rem;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .d-flex.justify-content-between {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }
        
        .search-container-inline {
            width: 100%;
        }
        
        .search-form-inline {
            min-width: 100%;
            flex-direction: column;
            border-radius: 16px;
            gap: 0;
        }
        
        .search-input-wrapper-inline {
            padding: 0.8rem 1.2rem;
            border-radius: 16px 16px 0 0;
        }
        
        .search-btn-inline {
            border-radius: 0 0 16px 16px;
            margin: 0;
            padding: 0.8rem 1.5rem;
            justify-content: center;
            background: var(--navy-primary);
        }
        
        .search-btn-inline:hover {
            background: var(--blue-medium);
            transform: translateY(-1px);
        }
        
        .search-results-info-inline {
            font-size: 0.85rem;
            text-align: left;
        }
    }
    
    @media (max-width: 576px) {
        .search-input-wrapper-inline {
            padding: 0.6rem 1rem;
        }
        
        .search-input-inline {
            font-size: 0.9rem;
            padding: 0.7rem 0;
        }
        
        .search-btn-inline {
            padding: 0.7rem 1.2rem;
            font-size: 0.9rem;
        }
    }
    
    @media (min-width: 992px) {
        .search-form-inline {
            min-width: 380px;
        }
    }
    
    @media (max-width: 992px) {
        .carousel-item {
            height: 350px;
        }
        
        .page-heading {
            font-size: 2rem;
        }
        
        .section-heading {
            font-size: 1.6rem;
        }
        
        .post-content {
            padding: 1.2rem;
        }
    }
    
    @media (max-width: 768px) {
        .carousel-item {
            height: 300px;
        }
        
        .post-img-container {
            padding-top: 130px; /* Altura fixa ligeiramente menor em telas médias */
        }
        
        .page-heading {
            font-size: 1.8rem;
        }
        
        .section-heading {
            font-size: 1.4rem;
        }
        
        .post-card {
            min-height: 330px; /* Altura mínima ajustada para telas médias */
        }
    }
    
    @media (max-width: 576px) {
        .carousel-item {
            height: 250px;
        }
        
        .post-img-container {
            padding-top: 120px; /* Altura fixa menor em telas pequenas */
        }
        
        .post-content {
            padding: 1.2rem;
        }
        
        .post-title {
            font-size: 1rem;
        }
        
        .page-heading {
            font-size: 1.6rem;
        }
        
        .section-heading {
            font-size: 1.3rem;
        }
        
        .post-card {
            min-height: 320px; /* Altura mínima ajustada para telas pequenas */
        }
    }
</style>

@php
$capasPostagens = [];
foreach ($postagens as $postagem) {
    if ($postagem->isPinned()) {
        $capa = $postagem->capa;
        if ($capa && Storage::disk('public')->exists($capa->imagem)) {
            $capasPostagens[] = [
                'postagem' => $postagem,
                'imagem' => $capa,
            ];
        }
    }
}
@endphp

<div class="container mt-4">
    <h1 class="page-heading">Ciência da Computação</h1>
    
    <div class="featured-carousel">
        <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                @foreach ($capasPostagens as $index => $item)
                    <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="{{ $index + 1 }}" aria-label="Slide {{ $index + 2 }}"></button>
                @endforeach
            </div>
            
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="{{ route('tcc.display') }}">
                        <img src="{{ asset('images/convite_tcc.png') }}" alt="TCCs em andamento ou concluídos" class="carousel-image w-100">
                        <div class="carousel-caption">
                            <h2>TCCs em andamento ou concluídos</h2>
                            <p>Explore os trabalhos de conclusão de curso dos alunos de Ciência da Computação</p>
                        </div>
                    </a>
                </div>
                
                @foreach ($capasPostagens as $index => $item)
                    <div class="carousel-item">
                        <a href="{{ route('postagem.show', ['id' => $item['postagem']->id]) }}">
                            <img src="{{ URL::asset('storage') }}/{{ $item['imagem']->imagem }}" alt="{{ $item['postagem']->titulo }}" class="carousel-image w-100">
                            <div class="carousel-caption">
                                <h2>{{ $item['postagem']->titulo }}</h2>
                                <p>{{ \Carbon\Carbon::parse($item['postagem']->created_at)->format('d/m/Y') }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Próximo</span>
            </button>
        </div>
    </div>
    
    <div class="mt-5 mb-3 d-flex justify-content-between align-items-center">
        <h2 class="section-heading mb-0">
            <i class="fas fa-newspaper"></i>
            Postagens Computação
        </h2>
        <div class="search-container-inline">
            <form action="{{ route('postagem.display') }}" method="GET" class="search-form-inline" role="search">
                <div class="search-input-wrapper-inline">
                    <i class="fas fa-search search-icon-inline"></i>
                    <input 
                        type="text" 
                        id="search-input"
                        name="buscar" 
                        class="search-input-inline" 
                        placeholder="Pesquisar postagens..." 
                        aria-label="Pesquisar postagens"
                        value="{{ $buscar ?? '' }}"
                        autocomplete="off"
                        spellcheck="false">
                    @if($buscar ?? false)
                        <a href="{{ route('postagem.display') }}" class="clear-search-inline" title="Limpar busca" aria-label="Limpar busca">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
                <button class="search-btn-inline" type="submit" aria-label="Realizar busca">
                    <i class="fas fa-search"></i>
                    <span>Buscar</span>
                </button>
            </form>
        </div>
    </div>
    @if($buscar ?? false)
        <div class="search-results-info-inline mb-3">
            <i class="fas fa-info-circle"></i>
            Resultados para: <strong>"{{ $buscar }}"</strong>
            <span class="results-count">({{ $postagens_9->total() }} {{ $postagens_9->total() === 1 ? 'resultado' : 'resultados' }})</span>
        </div>
    @endif
    
    <div class="posts-grid">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
            @foreach($postagens_9 as $postagem)
                <div class="col">
                    <div class="post-card">
                        <div class="post-img-container">
                            @if ($postagem->menu_inicial && $postagem->capa && Storage::disk('public')->exists($postagem->capa->imagem))
                                <a href="{{ route('postagem.show', ['id' => $postagem->id]) }}">
                                    <img src="{{ URL::asset('storage') }}/{{ $postagem->capa->imagem }}" alt="{{ $postagem->titulo }}" class="post-img">
                                </a>
                            @else
                                <a href="{{ route('postagem.show', ['id' => $postagem->id]) }}">
                                    <img src="{{ asset('images/postagem.png') }}" alt="{{ $postagem->titulo }}" class="post-img">
                                </a>
                            @endif
                        </div>
                        
                        <div class="post-content">
                            <h3 class="post-title">{{ $postagem->titulo }}</h3>
                            
                            <div class="post-meta">
                                <span class="post-date">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $postagem->created_at->format('d/m/Y H:i') }}
                                </span>
                                
                                <a href="{{ route('postagem.show', ['id' => $postagem->id]) }}" class="post-btn">
                                    Visualizar
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @php
    $paginatorText = $postagens_9->onEachSide(1)->links('pagination::bootstrap-5')->toHtml();
    $translatedPaginatorText = str_replace(
        ['Showing', 'to', 'of', 'results'],
        ['Mostrando de', 'a', 'de', 'resultados'],
        $paginatorText
    );
    @endphp

    <div class="pagination-container">
        <nav aria-label="Navegação entre páginas">
            {!! $translatedPaginatorText !!}
        </nav>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips do Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Adicionar animações de entrada aos cards quando ficam visíveis
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });
    
    document.querySelectorAll('.post-card').forEach(card => {
        observer.observe(card);
    });
    
    // Funcionalidade de busca completa
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.querySelector('.search-btn-inline');
    const searchForm = document.querySelector('.search-form-inline');
    const searchWrapper = document.querySelector('.search-input-wrapper-inline');
    
    if (searchInput && searchBtn && searchForm) {
        // Focar no input quando clicar no wrapper
        searchWrapper.addEventListener('click', function(e) {
            if (e.target !== searchInput) {
                searchInput.focus();
            }
        });
        
        // Permitir busca ao pressionar Enter
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchForm.submit();
            }
        });
        
        // Limpar campo de busca com Escape
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                this.blur();
            }
        });
        
        // Feedback visual ao submeter
        searchForm.addEventListener('submit', function(e) {
            if (searchInput.value.trim() === '') {
                e.preventDefault();
                searchInput.focus();
                searchInput.classList.add('shake');
                setTimeout(() => {
                    searchInput.classList.remove('shake');
                }, 500);
                return false;
            }
            
            // Loading no botão
            const btnText = searchBtn.querySelector('span');
            const btnIcon = searchBtn.querySelector('i');
            if (btnText && btnIcon) {
                btnIcon.className = 'fas fa-spinner fa-spin';
                btnText.textContent = 'Buscando...';
                searchBtn.disabled = true;
            }
        });
    }
});
</script>

<style>
    /* Animações e efeitos visuais */
    @keyframes shake {
        0%, 20%, 40%, 60%, 80% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
    }
    
    .shake { animation: shake 0.5s ease-in-out; }
    
    /* Garantir funcionalidade do input */
    .search-input-inline {
        cursor: text !important;
    }
    
    .search-input-wrapper-inline {
        cursor: text !important;
    }
</style>
@endsection
