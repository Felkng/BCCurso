@extends('layouts.main')
@section('title', 'Professores')
@section('content')

<div class="page-header">
    <div class="container">
        <div class="title-container">
            <div class="page-title">
                <i class="fas fa-chalkboard-teacher fa-2x"></i>
                <h2>Nosso Corpo Docente</h2>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="professors-grid">
        @foreach ($servidores as $servidor)
        <div class="professor-card" data-aos="fade-up" data-aos-duration="600" data-aos-delay="{{ $loop->index * 100 }}">
            <a href="{{ route('professor.view', ['id' => $servidor->id]) }}" class="professor-link">
                <div class="professor-image-container">
                    @if ($servidor->foto)
                        <img src="{{ URL::asset('storage') }}/{{ $servidor->foto }}" alt="{{ $servidor->nome }}" class="professor-image">
                    @else
                        <img src="{{ asset('images/professor/professor_placeholder.png') }}" alt="{{ $servidor->nome }}" class="professor-image">
                    @endif
                    <div class="professor-overlay">
                        <i class="fas fa-eye"></i>
                        <span>Ver Perfil</span>
                    </div>
                </div>
                <div class="professor-info">
                    <h3 class="professor-name">{{ $servidor->nome }}</h3>
                    <div class="professor-title">
                        @if(empty($servidor->titulacao))
                            <span class="title-badge">Professor</span>
                        @else
                            <span class="title-badge">{{ $servidor->titulacao }}</span>
                        @endif
                    </div>
                    @if(isset($servidor->professor) && $servidor->professor->coordenador)
                        <div class="coordinator-badge">
                            <i class="fas fa-star"></i>
                            Coordenador
                        </div>
                    @endif
                </div>
            </a>
        </div>
        @endforeach
    </div>
    
    @if($servidores->isEmpty())
        <div class="empty-state">
            <i class="fas fa-user-tie fa-5x"></i>
            <h3>Nenhum professor cadastrado</h3>
            <p>Em breve teremos informações sobre nosso corpo docente.</p>
        </div>
    @endif
</div>

<style>
.page-subtitle {
    color: var(--text-light);
    opacity: 0.9;
    font-size: 1.1rem;
    margin-top: 0.5rem;
}

.professors-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
    padding: 2rem 0;
}

.professor-card {
    background: white;
    border-radius: var(--border-radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    border: 2px solid rgba(28, 44, 76, 0.15);
    transition: var(--transition-normal);
    position: relative;
    height: 100%;
}

.professor-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg), 0 0 0 1px rgba(28, 44, 76, 0.2);
    border-color: rgba(28, 44, 76, 0.3);
}

.professor-link {
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
}

.professor-image-container {
    position: relative;
    height: 280px;
    overflow: hidden;
}

.professor-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition-normal);
}

.professor-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--bg-overlay);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: var(--transition-normal);
    color: white;
}

.professor-overlay i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.professor-overlay span {
    font-weight: 600;
    font-size: 1.1rem;
}

.professor-card:hover .professor-overlay {
    opacity: 1;
}

.professor-card:hover .professor-image {
    transform: scale(1.05);
}

.professor-info {
    padding: 1.5rem;
    text-align: center;
}

.professor-name {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--primary-blue);
    margin-bottom: 0.5rem;
    line-height: 1.3;
    min-height: 2.6rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.title-badge {
    display: inline-block;
    background: linear-gradient(135deg, var(--secondary-blue), var(--light-blue));
    color: white;
    padding: 0.4rem 1rem;
    border-radius: var(--border-radius-xl);
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.coordinator-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    background: var(--accent-green);
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: var(--border-radius-xl);
    font-size: 0.8rem;
    font-weight: 500;
    margin-top: 0.5rem;
}

.coordinator-badge i {
    font-size: 0.9rem;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-muted);
}

.empty-state i {
    color: var(--light-blue);
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    color: var(--primary-blue);
    margin-bottom: 1rem;
}

/* Responsividade */
@media (max-width: 768px) {
    .professors-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem 0;
    }
    
    .professor-image-container {
        height: 240px;
    }
    
    .professor-info {
        padding: 1.2rem;
    }
    
    .professor-name {
        font-size: 1.2rem;
    }
}

@media (max-width: 480px) {
    .professors-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .professor-image-container {
        height: 220px;
    }
}
</style>

<!-- AOS Animation Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 600,
        once: true,
        offset: 100
    });
</script>
@endsection