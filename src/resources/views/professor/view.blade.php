
@extends('layouts.main')
@section('title', 'Professor - ' . $servidor->nome)
@section('content')

<div class="page-header">
    <div class="container">
        <div class="breadcrumb-container">
            <a href="{{ route('professor.display') }}" class="breadcrumb-link">
                <i class="fas fa-chalkboard-teacher"></i>
                Professores
            </a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ $servidor->nome }}</span>
        </div>
    </div>
</div>

<div class="container">
    <div class="professor-profile">
        <!-- Hero Section -->
        <div class="professor-hero" data-aos="fade-up">
            <div class="professor-hero-content">
                <div class="professor-photo-container">
                    @if($professor->foto)
                        <img src="{{ URL::asset('storage') }}/{{ $professor->foto }}" alt="{{ $servidor->nome }}" class="professor-photo">
                    @else
                        <img src="{{ asset('images/professor/professor_placeholder.png') }}" alt="{{ $servidor->nome }}" class="professor-photo">
                    @endif
                    <div class="photo-frame"></div>
                </div>
                
                <div class="professor-hero-info">
                    <h1 class="professor-title">{{ $servidor->nome }}</h1>
                    
                    <div class="professor-badges">
                        @if($professor->titulacao)
                            <span class="title-badge">{{ $professor->titulacao }}</span>
                        @endif
                        
                        @if($professor->coordenador)
                            <span class="coordinator-badge">
                                <i class="fas fa-star"></i>
                                Coordenador de Curso
                            </span>
                        @else
                            <span class="role-badge">Professor</span>
                        @endif
                    </div>
                    
                    @if(isset($user->area) && $user->area)
                        <div class="area-specialization">
                            <i class="fas fa-graduation-cap"></i>
                            <span>{{ $user->area }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Information Cards Grid -->
        <div class="info-grid">
            <!-- Contact Card -->
            <div class="info-card contact-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-header">
                    <i class="fas fa-address-card"></i>
                    <h3>Informações de Contato</h3>
                </div>
                <div class="card-content">
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div class="info-details">
                            <span class="info-label">E-mail</span>
                            <a href="mailto:{{ $servidor->email }}" class="info-value email-link">{{ $servidor->email }}</a>
                        </div>
                    </div>
                    
                    @if(isset($professor->curriculos->first()->links) && $professor->curriculos->first()->links->count() > 0)
                        <div class="info-item">
                            <i class="fas fa-link"></i>
                            <div class="info-details">
                                <span class="info-label">Links Acadêmicos</span>
                                <div class="links-container">
                                    @foreach ($professor->curriculos->first()->links as $link)
                                        <a href="{{ $link->link }}" target="_blank" class="academic-link">
                                            <i class="fas fa-external-link-alt"></i>
                                            {{ parse_url($link->link, PHP_URL_HOST) ?: $link->link }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Biography Card -->
            @if($professor->biografia)
            <div class="info-card biography-card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <i class="fas fa-user-graduate"></i>
                    <h3>Biografia</h3>
                </div>
                <div class="card-content">
                    <p class="biography-text">{{ $professor->biografia }}</p>
                </div>
            </div>
            @endif

            <!-- Academic Info Card -->
            <div class="info-card academic-card" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header">
                    <i class="fas fa-university"></i>
                    <h3>Informações Acadêmicas</h3>
                </div>
                <div class="card-content">
                    @if($professor->titulacao)
                        <div class="info-item">
                            <i class="fas fa-medal"></i>
                            <div class="info-details">
                                <span class="info-label">Titulação</span>
                                <span class="info-value">{{ $professor->titulacao }}</span>
                            </div>
                        </div>
                    @endif
                    
                    <div class="info-item">
                        <i class="fas fa-briefcase"></i>
                        <div class="info-details">
                            <span class="info-label">Função</span>
                            <span class="info-value">
                                @if($professor->coordenador)
                                    <span class="coordinator-text">
                                        <i class="fas fa-star"></i>
                                        Coordenador de Curso
                                    </span>
                                @else
                                    Professor
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    @if(isset($professor->area) && $professor->area)
                        <div class="info-item">
                            <i class="fas fa-microscope"></i>
                            <div class="info-details">
                                <span class="info-label">Área de Atuação</span>
                                <span class="info-value">{{ $professor->area }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons" data-aos="fade-up" data-aos-delay="400">
            <a href="{{ url()->previous() }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i>
                Voltar
            </a>
            <a href="{{ route('professor.display') }}" class="btn btn-secondary">
                <i class="fas fa-users"></i>
                Ver Todos os Professores
            </a>
        </div>
    </div>
</div>

<style>
.page-header {
    background: var(--primary-blue);
    color: white;
    padding: 2rem 0 1.5rem;
    margin-bottom: 0;
}

.breadcrumb-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
}

.breadcrumb-link {
    color: var(--text-light);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    opacity: 0.8;
    transition: var(--transition-fast);
}

.breadcrumb-link:hover {
    color: var(--text-light);
    opacity: 1;
    text-decoration: none;
}

.breadcrumb-separator {
    color: var(--text-light);
    opacity: 0.6;
}

.breadcrumb-current {
    font-weight: 500;
}

.professor-profile {
    padding: 0;
}

.professor-hero {
    background: white;
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    margin-bottom: 2rem;
}

.professor-hero-content {
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 2.5rem;
    padding: 2.5rem;
    align-items: center;
}

.professor-photo-container {
    position: relative;
    display: flex;
    flex-shrink: 0;
}

.professor-photo {
    width: 180px;
    height: 180px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid transparent;
    background: radial-gradient(circle at center, #0a1423 0%, #1c2c4c 40%, rgba(61, 116, 197, 0.9) 70%, rgba(255, 255, 255, 0.8) 100%);
    background-clip: border-box;
    position: relative;
    z-index: 2;
}

.photo-frame {
    display: none;
}

.professor-hero-info {
    min-width: 0;
}

.professor-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--primary-blue);
    margin-bottom: 1rem;
    line-height: 1.2;
}

.professor-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.8rem;
    margin-bottom: 1rem;
}

.title-badge {
    display: inline-block;
    background: var(--secondary-blue);
    color: white;
    padding: 0.5rem 1.2rem;
    border-radius: var(--border-radius-xl);
    font-size: 0.9rem;
    font-weight: 600;
}

.coordinator-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: var(--accent-green);
    color: white;
    padding: 0.5rem 1.2rem;
    border-radius: var(--border-radius-xl);
    font-size: 0.9rem;
    font-weight: 600;
}

.role-badge {
    display: inline-block;
    background: var(--primary-blue);
    color: white;
    padding: 0.5rem 1.2rem;
    border-radius: var(--border-radius-xl);
    font-size: 0.9rem;
    font-weight: 600;
}

.area-specialization {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-muted);
    font-size: 1.1rem;
    font-style: italic;
}

.area-specialization i {
    color: var(--light-blue);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.info-card {
    background: white;
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    transition: var(--transition-normal);
}

.info-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
}

.card-header {
    background: var(--primary-blue);
    color: white;
    padding: 1.2rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.card-header i {
    font-size: 1.3rem;
}

.card-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}

.card-content {
    padding: 1.5rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.2rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-item i {
    color: var(--secondary-blue);
    font-size: 1.1rem;
    margin-top: 0.2rem;
    flex-shrink: 0;
}

.info-details {
    flex: 1;
    min-width: 0;
}

.info-label {
    display: block;
    font-size: 0.85rem;
    color: var(--text-muted);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.3rem;
}

.info-value {
    display: block;
    color: var(--primary-blue);
    font-size: 1rem;
    font-weight: 500;
    line-height: 1.4;
    word-wrap: break-word;
}

.email-link {
    color: var(--secondary-blue);
    text-decoration: none;
    transition: var(--transition-fast);
}

.email-link:hover {
    color: var(--primary-blue);
    text-decoration: underline;
}

.links-container {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.academic-link {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    color: var(--secondary-blue);
    text-decoration: none;
    font-size: 0.9rem;
    padding: 0.4rem 0.8rem;
    background: rgba(70, 130, 180, 0.1);
    border-radius: var(--border-radius-sm);
    transition: var(--transition-fast);
    width: fit-content;
}

.academic-link:hover {
    background: var(--secondary-blue);
    color: white;
    text-decoration: none;
}

.biography-text {
    color: var(--primary-blue);
    line-height: 1.7;
    font-size: 1rem;
    margin: 0;
}

.coordinator-text {
    color: var(--accent-green);
    font-weight: 600;
}

.coordinator-text i {
    color: var(--accent-green);
}

.action-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    padding: 2rem 0;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.8rem;
    border-radius: var(--border-radius-xl);
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition-normal);
    border: none;
    cursor: pointer;
    font-size: 0.95rem;
}

.btn-back {
    background: var(--primary-blue);
    color: white;
}

.btn-back:hover {
    background: var(--secondary-blue);
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
}

.btn-secondary {
    background: white;
    color: var(--primary-blue);
    border: 2px solid var(--primary-blue);
}

.btn-secondary:hover {
    background: var(--primary-blue);
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
}

/* Responsividade */
@media (max-width: 768px) {
    .professor-hero-content {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 2rem;
        padding: 2rem 1.5rem;
    }
    
    .professor-photo {
        width: 150px;
        height: 150px;
    }
    
    .photo-frame {
        width: 150px;
        height: 150px;
    }
    
    .professor-title {
        font-size: 1.8rem;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .page-header {
        padding: 1.5rem 0 1rem;
    }
    
    .professor-hero-content {
        padding: 1.5rem 1rem;
        gap: 1.5rem;
    }
    
    .professor-photo {
        width: 120px;
        height: 120px;
    }
    
    .photo-frame {
        width: 120px;
        height: 120px;
    }
    
    .professor-title {
        font-size: 1.6rem;
    }
    
    .card-content {
        padding: 1.2rem;
    }
    
    .breadcrumb-container {
        font-size: 0.9rem;
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
