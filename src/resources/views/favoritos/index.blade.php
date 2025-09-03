@extends('layouts.main')

@section('title', 'Meus Favoritos')

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
    
    .empty-state {
        text-align: center;
        padding: 3rem 0;
        color: var(--navy-primary);
    }
    
    .empty-state i {
        color: var(--blue-medium);
    }
    
    .empty-state h4 {
        color: var(--navy-primary);
    }
    
    .empty-state p {
        color: var(--text-dark);
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
        min-height: 350px;
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
    
    .btn-remove {
        background-color: #dc3545;
        border: none;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        margin-left: 0.5rem;
    }
    
    .btn-remove:hover {
        background-color: #c82333;
        color: white;
    }
    
    /* TCC Cards */
    .tcc-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: none;
        background-color: var(--text-light);
        display: flex;
        flex-direction: column;
        min-height: 350px;
    }
    
    .tcc-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }
    
    .tcc-img-placeholder {
        width: 100%;
        height: 150px;
        background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<style>
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
}

.card-img-container {
    position: relative;
    overflow: hidden;
}

.card-img-container img {
    transition: transform 0.3s ease;
}

.hover-card:hover .card-img-container img {
    transform: scale(1.05);
}

.empty-state {
    color: #6c757d;
    font-style: italic;
}

.card-title {
    font-size: 1.1rem;
    line-height: 1.3;
}

.card-text {
    font-size: 0.9rem;
    line-height: 1.4;
}

.btn-sm {
    font-size: 0.8rem;
}
</style>
<div class="custom-container">
    <div>
        <div>
            <i class="fas fa-heart fa-2x"></i>
            <h3 class="smaller-font form-label">Meus Favoritos</h3>
        </div>
    </div>
</div>

<div class="container">
    @if($postagensFavoritas->isEmpty() && $tccsFavoritos->isEmpty())
        <div class="empty-state text-center py-5">
            <i class="fas fa-heart fa-4x text-muted mb-4"></i>
            <h4 class="text-muted mb-3">Você ainda não tem favoritos</h4>
            <p class="text-muted">Explore as postagens e TCCs e adicione aos seus favoritos!</p>
        </div>
    @else
        <!-- Postagens Favoritas -->
        @if($postagensFavoritas->isNotEmpty())
            <div class="mb-5">
                <h2 class="section-heading">
                    <i class="fas fa-newspaper"></i>
                    Postagens Favoritas ({{ $postagensFavoritas->count() }})
                </h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
                    @foreach($postagensFavoritas as $favorito)
                        @php $postagem = $favorito->favoritavel; @endphp
                        <div class="col">
                            <div class="post-card">
                                <div class="post-img-container">
                                    @if($postagem->menu_inicial && $postagem->capa && Storage::disk('public')->exists($postagem->capa->imagem))
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
                                        
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('postagem.show', ['id' => $postagem->id]) }}" class="post-btn">
                                                Visualizar
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                            <form method="POST" action="{{ route('favoritos.toggle') }}" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="type" value="postagem">
                                                <input type="hidden" name="id" value="{{ $postagem->id }}">
                                                <button type="submit" class="btn-remove" title="Remover dos favoritos">
                                                    <i class="fas fa-heart-broken"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- TCCs Favoritos -->
        @if($tccsFavoritos->isNotEmpty())
            <div class="mb-5">
                <h2 class="section-heading">
                    <i class="fas fa-graduation-cap"></i>
                    TCCs Favoritos ({{ $tccsFavoritos->count() }})
                </h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
                    @foreach($tccsFavoritos as $favorito)
                        @php $tcc = $favorito->favoritavel; @endphp
                        <div class="col">
                            <div class="tcc-card">
                                <div class="tcc-img-placeholder">
                                    <i class="fas fa-graduation-cap fa-3x text-white opacity-75"></i>
                                </div>
                                
                                <div class="post-content">
                                    <h3 class="post-title">{{ $tcc->titulo }}</h3>
                                    
                                    <div class="post-meta">
                                        <div class="d-flex flex-column">
                                            <span class="post-date">
                                                <i class="fas fa-user me-1"></i>
                                                {{ $tcc->aluno->name ?? 'Aluno não encontrado' }}
                                            </span>
                                            <span class="post-date mt-1">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ $tcc->ano }}
                                            </span>
                                        </div>
                                        
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('tcc.view', $tcc->id) }}" class="post-btn">
                                                Visualizar
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                            <form method="POST" action="{{ route('favoritos.toggle') }}" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="type" value="tcc">
                                                <input type="hidden" name="id" value="{{ $tcc->id }}">
                                                <button type="submit" class="btn-remove" title="Remover dos favoritos">
                                                    <i class="fas fa-heart-broken"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
