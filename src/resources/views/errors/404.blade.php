@extends('layouts.main')
@section('title', 'Página não encontrada')
@section('content')

<style>
    .error-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 4rem 1rem;
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .error-code {
        font-size: 8rem;
        font-weight: 800;
        color: var(--primary-blue);
        margin-bottom: 0;
        line-height: 1;
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 5px 15px rgba(28, 44, 76, 0.1);
    }
    
    .error-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin: 1rem 0 2rem;
    }
    
    .error-message {
        font-size: 1.2rem;
        color: #4a5568;
        max-width: 600px;
        margin-bottom: 2.5rem;
        line-height: 1.6;
    }
    
    .error-illustration {
        max-width: 450px;
        margin-bottom: 2rem;
        filter: drop-shadow(0 10px 15px rgba(28, 44, 76, 0.1));
        animation: float 6s ease-in-out infinite;
    }
    
    .error-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: center;
    }
    
    .error-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: var(--primary-blue);
        color: white;
        padding: 0.8rem 1.5rem;
        border-radius: var(--border-radius-xl);
        text-decoration: none;
        font-weight: 600;
        transition: all var(--transition-normal);
        box-shadow: var(--shadow-md);
    }
    
    .error-button:hover {
        background-color: var(--secondary-blue);
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        color: white;
        text-decoration: none;
    }
    
    .error-button-secondary {
        background-color: #f8fafc;
        color: var(--primary-blue);
        border: 2px solid var(--primary-blue);
    }
    
    .error-button-secondary:hover {
        background-color: #f1f5f9;
        color: var(--primary-blue);
    }
    
    .wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 150px;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%231c2c4c" fill-opacity="0.05" d="M0,192L48,176C96,160,192,128,288,122.7C384,117,480,139,576,154.7C672,171,768,181,864,170.7C960,160,1056,128,1152,117.3C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
        background-size: 1440px 320px;
        background-repeat: repeat-x;
        z-index: -1;
    }
    
    @keyframes float {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-15px);
        }
        100% {
            transform: translateY(0px);
        }
    }
    
    @media (max-width: 768px) {
        .error-code {
            font-size: 6rem;
        }
        
        .error-title {
            font-size: 1.8rem;
        }
        
        .error-message {
            font-size: 1rem;
        }
        
        .error-illustration {
            max-width: 300px;
        }
    }
</style>

<div class="error-container">
    <h1 class="error-code">404</h1>
    <h2 class="error-title">Ops! Página não encontrada</h2>
    <p class="error-message">A página que você está procurando parece não existir. 
        Pode ter sido movida, excluída ou talvez nunca tenha existido. 
        Isso acontece até com os melhores de nós!</p>
    
    <img src="{{ asset('images/404-illustration.svg') }}" alt="Página não encontrada" class="error-illustration" 
         onerror="this.onerror=null; this.src='{{ asset('images/logo-criada.png') }}'; this.style.maxWidth='200px'">
    
    <div class="error-actions">
        <a href="{{ route('postagem.display') }}" class="error-button">
            <i class="fas fa-home"></i> Voltar para o Início
        </a>
        <a href="{{ url()->previous() }}" class="error-button error-button-secondary">
            <i class="fas fa-arrow-left"></i> Voltar para a página anterior
        </a>
    </div>
</div>

<div class="wave"></div>

@endsection
