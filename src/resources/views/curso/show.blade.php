@extends('layouts.main')
@section('title', 'Sobre o Curso')
@section('content')

<style>
.curso-page-content {
    --primary-blue: #0f2257;
    --secondary-blue: #2563eb;
    --light-blue: #dbeafe;
    --accent-blue: #1d4ed8;
    --navy-blue: #0f2b76;
    --text-dark: #1f2937;
    --text-light: #6b7280;
    --border-color: #e5e7eb;
    --background-light: #f8fafc;
}

.curso-page-content .institutional-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.curso-page-content .page-header {
    background: var(--primary-blue);
    color: white;
    padding: 60px 0;
    margin-bottom: 0;
}

.curso-page-content .page-header h1 {
    font-size: 2.5rem;
    font-weight: 300;
    text-align: center;
    margin-bottom: 10px;
    letter-spacing: 1px;
}

.curso-page-content .page-header .subtitle {
    text-align: center;
    font-size: 1.1rem;
    opacity: 0.9;
    font-weight: 300;
}

.curso-page-content .section-navigation {
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-bottom: 3px solid var(--secondary-blue);
    position: sticky;
    top: 0;
    z-index: 100;
}

.curso-page-content .nav-tabs {
    display: flex;
    justify-content: center;
    max-width: 1200px;
    margin: 0 auto;
}

.curso-page-content .nav-tab {
    flex: 1;
    text-align: center;
    padding: 20px;
    color: var(--text-dark);
    text-decoration: none;
    font-weight: 500;
    font-size: 1rem;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
}

.curso-page-content .nav-tab:hover {
    background-color: var(--light-blue);
    color: var(--primary-blue);
    text-decoration: none;
}

.curso-page-content .nav-tab.active {
    color: var(--primary-blue);
    border-bottom-color: var(--primary-blue);
    background-color: var(--light-blue);
}

.curso-page-content .content-section {
    padding: 60px 0;
    border-bottom: 1px solid var(--border-color);
}

.curso-page-content .content-section:last-child {
    border-bottom: none;
}

.curso-page-content .section-title {
    font-size: 2rem;
    color: var(--primary-blue);
    font-weight: 600;
    margin-bottom: 40px;
    text-align: center;
    position: relative;
}

.curso-page-content .section-title::after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background-color: var(--secondary-blue);
    margin: 20px auto;
}

.curso-page-content .info-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.curso-page-content .info-card {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.curso-page-content .info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(30, 58, 138, 0.15);
}

.curso-page-content .info-card h3 {
    color: var(--primary-blue);
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 15px;
    border-bottom: 2px solid var(--light-blue);
    padding-bottom: 10px;
}

.curso-page-content .info-card p, .curso-page-content .info-card ul {
    color: var(--text-dark);
    line-height: 1.6;
    margin-bottom: 15px;
}

.curso-page-content .info-card ul {
    padding-left: 20px;
}

.curso-page-content .info-card li {
    margin-bottom: 8px;
}

.curso-page-content .course-description {
    background: var(--background-light);
    padding: 50px;
    border-left: 5px solid var(--secondary-blue);
    margin: 40px 0;
    border-radius: 0 8px 8px 0;
}

.curso-page-content .course-description p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--text-dark);
    text-align: justify;
}

.curso-page-content .quality-badges {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin: 40px 0;
    flex-wrap: wrap;
}

.curso-page-content .quality-badge {
    background: linear-gradient(135deg, #0f2257, #0f2b76);
    color: white;
    padding: 20px 30px;
    border-radius: 50px;
    font-weight: 600;
    text-align: center;
    box-shadow: 0 4px 15px rgba(15, 34, 87, 0.25);
}

.curso-page-content .quality-badge .badge-title {
    font-size: 1.1rem;
    margin-bottom: 5px;
}

.curso-page-content .quality-badge .badge-value {
    font-size: 2rem;
    font-weight: 700;
}

.curso-page-content .document-links {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin: 40px 0;
}

.curso-page-content .document-link {
    display: block;
    background: white;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 25px;
    text-decoration: none;
    color: var(--text-dark);
    transition: all 0.3s ease;
    text-align: center;
}

.curso-page-content .document-link:hover {
    border-color: var(--secondary-blue);
    background: var(--light-blue);
    text-decoration: none;
    color: var(--primary-blue);
}

.curso-page-content .document-link i {
    font-size: 2.5rem;
    color: var(--secondary-blue);
    margin-bottom: 15px;
    display: block;
}

.curso-page-content .document-link .doc-title {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 8px;
}

.curso-page-content .document-link .doc-description {
    font-size: 0.9rem;
    color: var(--text-light);
}

.curso-page-content .primary-action {
    text-align: center;
    margin: 50px 0;
}

.curso-page-content .btn-institutional {
    background: linear-gradient(135deg, var(--primary-blue), var(--navy-blue));
    color: white;
    padding: 18px 40px;
    font-size: 1.1rem;
    font-weight: 600;
    text-decoration: none;
    border-radius: 50px;
    display: inline-block;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(15, 34, 87, 0.3);
    border: none;
}

.curso-page-content .btn-institutional:hover {
    background: linear-gradient(135deg, var(--navy-blue), var(--primary-blue));
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(15, 34, 87, 0.4);
    color: white;
    text-decoration: none;
}

.curso-page-content .back-section {
    text-align: center;
    margin: 40px 0;
    padding: 40px 0;
    border-top: 1px solid var(--border-color);
}

.curso-page-content .btn-back {
    background: white;
    color: var(--text-dark);
    border: 2px solid var(--border-color);
    padding: 12px 30px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.curso-page-content .btn-back:hover {
    border-color: var(--secondary-blue);
    background: var(--light-blue);
    color: var(--primary-blue);
    text-decoration: none;
}

@media (max-width: 768px) {
    .curso-page-content .page-header h1 {
        font-size: 2rem;
    }
    
    .curso-page-content .nav-tabs {
        flex-direction: column;
    }
    
    .curso-page-content .nav-tab {
        border-bottom: 1px solid var(--border-color);
        border-right: none;
    }
    
    .curso-page-content .quality-badges {
        flex-direction: column;
        align-items: center;
    }
    
    .curso-page-content .course-description {
        padding: 30px 20px;
    }
    
    .curso-page-content .content-section {
        padding: 40px 0;
    }
    
    .curso-page-content .info-cards {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .curso-page-content .document-links {
        grid-template-columns: 1fr;
    }
}

.curso-page-content .data-table {
    width: 100%;
    border-collapse: collapse;
    margin: 30px 0;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.curso-page-content .data-table th {
    background: var(--primary-blue);
    color: white;
    padding: 15px;
    text-align: left;
    font-weight: 600;
}

.curso-page-content .data-table td {
    padding: 15px;
    border-bottom: 1px solid var(--border-color);
}

.curso-page-content .data-table tr:hover {
    background: var(--background-light);
}
</style>

<div class="curso-page-content">
<!-- Header da página -->
<div class="page-header">
    <div class="institutional-container">
        <h1>Curso de {{$curso->nome}}</h1>
        <p class="subtitle">Instituto Federal do Norte de Minas Gerais - Campus Montes Claros</p>
    </div>
</div>

<!-- Navegação por seções -->
<nav class="section-navigation">
    <div class="nav-tabs">
        <a href="#sobre" class="nav-tab">Sobre o Curso</a>
        <a href="#dados" class="nav-tab">Dados Gerais</a>
        <a href="#documentos" class="nav-tab">Documentos</a>
        <a href="#admissao" class="nav-tab">Admissão</a>
    </div>
</nav>

<div class="institutional-container">
    
    <!-- Seção: Sobre o Curso -->
    <section id="sobre" class="content-section">
        <h2 class="section-title">Sobre o Curso de {{$curso->nome}} ({{$curso->sigla}})</h2>
        
        <div class="course-description">
            <p>{{$curso->descricao}}</p>
        </div>

        <!-- Badges de qualidade -->
        <div class="quality-badges">
            <div class="quality-badge">
                <div class="badge-title">Avaliação SINAES</div>
                <div class="badge-value">{{$curso->nota_in_loco_SINAES}}</div>
            </div>
            <div class="quality-badge">
                <div class="badge-title">Nota ENADE</div>
                <div class="badge-value">{{$curso->nota_enade}}</div>
            </div>
        </div>

        <p style="text-align: center; color: var(--text-light); font-style: italic; margin-top: 20px;">
            Resultados obtidos nas últimas avaliações realizadas pelo Ministério da Educação (MEC)
        </p>
    </section>

    <!-- Seção: Dados Gerais -->
    <section id="dados" class="content-section">
        <h2 class="section-title">Dados Gerais do Curso</h2>
        
        <div class="info-cards">
            <div class="info-card">
                <h3>Informações Básicas</h3>
                <p><strong>Modalidade:</strong> {{$curso->modalidade}}</p>
                <p><strong>Tipo:</strong> {{$curso->tipo}}</p>
                <p><strong>Turno:</strong> {{$curso->turno}}</p>
                <p><strong>Habilitação:</strong> {{$curso->habilitacao}}</p>
                <p><strong>Ano de Implementação:</strong> {{$curso->ano_implementacao}}</p>
            </div>

            <div class="info-card">
                <h3>Duração e Carga Horária</h3>
                <p><strong>Tempo Mínimo:</strong> {{$curso->tempo_min_conclusao}} anos</p>
                <p><strong>Tempo Máximo:</strong> {{$curso->tempo_max_conclusao}} anos</p>
                <p><strong>Carga Horária Total:</strong> {{$curso->carga_horaria}} horas</p>
            </div>

            <div class="info-card">
                <h3>Vagas e Ingresso</h3>
                <p><strong>Vagas Anuais:</strong> {{$curso->vagas_ofertadas_anualmente}} vagas</p>
                <p><strong>Vagas por Turma:</strong> {{$curso->vagas_ofertadas_turma}} vagas</p>
                <p><strong>Periodicidade:</strong> {{$curso->periodicidade_ingresso}}</p>
            </div>
        </div>
    </section>

    <!-- Seção: Documentos -->
    <section id="documentos" class="content-section">
        <h2 class="section-title">Documentos Institucionais</h2>
        
        <div class="document-links">
            @if($curso->ppc && $curso->ppc->count() > 0)
                <a href="{{ asset('storage/' . $curso->ppc[0]->path) }}" target="_blank" class="document-link">
                    <i class="fas fa-file-pdf"></i>
                    <div class="doc-title">Projeto Pedagógico do Curso</div>
                    <div class="doc-description">Acesse o PPC completo</div>
                </a>
                
                <a href="{{ asset('storage/' . $curso->ppc[0]->matriz->path) }}" target="_blank" class="document-link">
                    <i class="fas fa-table"></i>
                    <div class="doc-title">Matriz Curricular</div>
                    <div class="doc-description">Estrutura curricular do curso</div>
                </a>
            @else
                <div class="info-card">
                    <h3>Documentos Indisponíveis</h3>
                    <p>Os documentos do Projeto Pedagógico e Matriz Curricular não estão disponíveis no momento.</p>
                </div>
            @endif
            
            <a href="{{ asset('storage/' . $curso->calendario) }}" target="_blank" class="document-link">
                <i class="fas fa-calendar-alt"></i>
                <div class="doc-title">Calendário Acadêmico</div>
                <div class="doc-description">Cronograma do ano letivo</div>
            </a>
            
            <a href="{{ asset('storage/' . $curso->horario) }}" target="_blank" class="document-link">
                <i class="fas fa-clock"></i>
                <div class="doc-title">Horário das Disciplinas</div>
                <div class="doc-description">Grade de horários atualizada</div>
            </a>
        </div>

        @if($curso->analytics)
        <div style="text-align: center; margin-top: 40px;">
            <a href="{{$curso->analytics}}" target="_blank" class="btn-institutional">
                <i class="fas fa-chart-bar" style="margin-right: 10px;"></i>
                Estatísticas e Analytics
            </a>
        </div>
        @endif
    </section>

    <!-- Seção: Admissão -->
    <section id="admissao" class="content-section">
        <h2 class="section-title">Processo de Admissão</h2>
        
        <div class="info-cards">
            <div class="info-card">
                <h3>Formas de Acesso</h3>
                <ul>
                    @foreach($curso->formasAcesso as $formaAcesso)
                        <li><strong>{{$formaAcesso->forma_acesso}}</strong> - {{$formaAcesso->porcentagem_vagas}}% das vagas</li>
                    @endforeach
                </ul>
            </div>
            
            <div class="info-card">
                <h3>Informações de Vagas</h3>
                <p><strong>Total de vagas anuais:</strong> {{$curso->vagas_ofertadas_anualmente}} vagas</p>
                <p><strong>Vagas por turma:</strong> {{$curso->vagas_ofertadas_turma}} vagas</p>
                <p><strong>Ingresso:</strong> {{$curso->periodicidade_ingresso}}</p>
            </div>
        </div>

        <div class="primary-action">
            <a href="https://www.ifnmg.edu.br/estude-no-ifnmg" target="_blank" class="btn-institutional">
                <i class="fas fa-graduation-cap" style="margin-right: 10px;"></i>
                Estude no IFNMG
            </a>
        </div>
    </section>

    <!-- Seção Voltar -->
    <div class="back-section">
        <a href="{{ url()->previous() }}" class="btn-back">
            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>
            Voltar
        </a>
    </div>
</div>

<script>
// Navegação suave e highlight da seção ativa
document.addEventListener('DOMContentLoaded', function() {
    const navTabs = document.querySelectorAll('.nav-tab');
    const sections = document.querySelectorAll('.content-section');
    
    // Função para atualizar tab ativo
    function updateActiveTab() {
        const scrollPos = window.scrollY + 100;
        
        sections.forEach((section, index) => {
            const sectionTop = section.offsetTop;
            const sectionBottom = sectionTop + section.offsetHeight;
            
            if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
                navTabs.forEach(tab => tab.classList.remove('active'));
                navTabs[index].classList.add('active');
            }
        });
    }
    
    // Event listener para scroll
    window.addEventListener('scroll', updateActiveTab);
    
    // Event listener para cliques nos tabs
    navTabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            const offsetTop = target.offsetTop - 80; // Offset para navegação fixa
            
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        });
    });
    
    // Definir tab ativo inicial
    updateActiveTab();
});
</script>
</div>

@endsection
