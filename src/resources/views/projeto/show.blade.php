@extends('layouts.main')
@section('title', $projeto->titulo)
@section('content')

<style>
    .project-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #6c757d;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
        margin-bottom: 1rem;
    }
    
    .back-button:hover {
        color: #495057;
        text-decoration: none;
    }
    
    .project-card {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .project-header {
        background-color: #1c2c4c;
        color: white;
        padding: 2rem 2rem 1.5rem 2rem;
    }
    
    .project-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }
    
    .project-coordinator {
        color: #dbe9f6;
        font-size: 1.1rem;
        margin-bottom: 0;
    }
    
    .project-body {
        padding: 0;
    }
    
    .project-field {
        display: flex;
        padding: 1.25rem 2rem;
        border-bottom: 1px solid #f1f3f4;
        align-items: flex-start;
    }
    
    .project-field:last-child {
        border-bottom: none;
    }
    
    .field-label {
        font-weight: 600;
        color: #495057;
        min-width: 180px;
        flex-shrink: 0;
        margin-bottom: 0;
    }
    
    .field-value {
        color: #6c757d;
        margin-bottom: 0;
        flex: 1;
        line-height: 1.5;
    }
    
    .field-value.description {
        text-align: justify;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .status-ongoing {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-finished {
        background-color: #d4edda;
        color: #155724;
    }
    
    .keywords-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .keyword-tag {
        background-color: #e9ecef;
        color: #495057;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.875rem;
    }
    
    .team-members {
        margin: 0;
    }
    
    .team-members li {
        margin-bottom: 0.25rem;
        color: #6c757d;
    }
    
    .external-link {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }
    
    .external-link:hover {
        text-decoration: underline;
    }
    
    .images-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 0.75rem;
        margin-top: 0.5rem;
    }
    
    .gallery-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .gallery-image:hover {
        transform: scale(1.05);
    }
    
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
    
    .modal-image {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        border-radius: 8px;
    }
    
    .modal-close {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .modal-close:hover {
        color: #fff;
    }
    
    @media (max-width: 768px) {
        .project-field {
            flex-direction: column;
            padding: 1rem 1.5rem;
        }
        
        .field-label {
            min-width: auto;
            margin-bottom: 0.5rem;
        }
        
        .project-header {
            padding: 1.5rem;
        }
        
        .project-title {
            font-size: 1.5rem;
        }
        
        .images-gallery {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        }
    }
</style>

<div class="project-container">
    <a href="{{ url()->previous() }}" class="back-button">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
    
    <div class="project-card">
        <div class="project-header">
            <h1 class="project-title">{{ $projeto->titulo }}</h1>
            <p class="project-coordinator">
                <i class="fas fa-user-tie me-2"></i>
                Coordenado por {{ $projeto->professor->servidor->nome }}
            </p>
        </div>
        
        <div class="project-body">
            <div class="project-field">
                <h6 class="field-label">Descrição:</h6>
                <p class="field-value description">{{ $projeto->descricao }}</p>
            </div>
            
            <div class="project-field">
                <h6 class="field-label">Data de Início:</h6>
                <p class="field-value">{{ date('d/m/Y', strtotime($projeto->data_inicio)) }}</p>
            </div>
            
            <div class="project-field">
                <h6 class="field-label">Status:</h6>
                <div class="field-value">
                    @if($projeto->data_termino)
                        @php
                            $dataTermino = \Carbon\Carbon::parse($projeto->data_termino);
                            $hoje = \Carbon\Carbon::now();
                        @endphp
                        
                        @if($hoje->lt($dataTermino))
                            <span class="status-badge status-ongoing">
                                Em andamento, encerra em {{ $dataTermino->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="status-badge status-finished">
                                Finalizado em {{ $dataTermino->format('d/m/Y') }}
                            </span>
                        @endif
                    @else
                        <span class="status-badge status-ongoing">Em andamento</span>
                    @endif
                </div>
            </div>
            
            @if($projeto->palavras_chave)
            <div class="project-field">
                <h6 class="field-label">Palavras-chave:</h6>
                <div class="field-value">
                    <div class="keywords-container">
                        @foreach(explode(',', $projeto->palavras_chave) as $keyword)
                            <span class="keyword-tag">{{ trim($keyword) }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            @if(count($projeto->professoresColaboradores) > 0)
            <div class="project-field">
                <h6 class="field-label">Professores Colaboradores:</h6>
                <div class="field-value">
                    <ul class="team-members list-unstyled">
                        @foreach($projeto->professoresColaboradores as $profColab)
                            <li>• {{ $profColab->servidor->nome }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            
            @if(count($projeto->professoresExternos) > 0)
            <div class="project-field">
                <h6 class="field-label">Professores Externos:</h6>
                <div class="field-value">
                    <ul class="team-members list-unstyled">
                        @foreach($projeto->professoresExternos as $profExterno)
                            <li>• {{ $profExterno->nome }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            
            @if(count($projeto->alunosBolsistas) > 0)
            <div class="project-field">
                <h6 class="field-label">Alunos Bolsistas:</h6>
                <div class="field-value">
                    <ul class="team-members list-unstyled">
                        @foreach($projeto->alunosBolsistas as $alunoBolsista)
                            <li>• {{ $alunoBolsista->nome }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            
            @if(count($projeto->alunosVoluntarios) > 0)
            <div class="project-field">
                <h6 class="field-label">Alunos Voluntários:</h6>
                <div class="field-value">
                    <ul class="team-members list-unstyled">
                        @foreach($projeto->alunosVoluntarios as $alunoVoluntario)
                            <li>• {{ $alunoVoluntario->nome }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            
            @if($projeto->resultados)
            <div class="project-field">
                <h6 class="field-label">Resultados:</h6>
                <p class="field-value">{{ $projeto->resultados }}</p>
            </div>
            @endif
            
            @if($projeto->fomento)
            <div class="project-field">
                <h6 class="field-label">Fomento:</h6>
                <p class="field-value">{{ $projeto->fomento }}</p>
            </div>
            @endif
            
            @if($projeto->link)
            <div class="project-field">
                <h6 class="field-label">Página do Projeto:</h6>
                <p class="field-value">
                    <a href="{{ $projeto->link }}" target="_blank" class="external-link">
                        {{ $projeto->link }} <i class="fas fa-external-link-alt ms-1"></i>
                    </a>
                </p>
            </div>
            @endif
            
            @if(count($projeto->imagens) > 0)
            <div class="project-field">
                <h6 class="field-label">Imagens:</h6>
                <div class="field-value">
                    <div class="images-gallery">
                        @foreach($projeto->imagens as $img)
                            <img src="{{ asset('storage/' . $img->imagem) }}" 
                                 alt="Imagem do Projeto" 
                                 class="gallery-image"
                                 onclick="openImageModal(this.src)">
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para Visualizar Imagens -->
<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <img id="modalImage" class="modal-image">
    <span class="modal-close">&times;</span>
</div>

<script>
    function openImageModal(src) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        modal.style.display = 'flex';
        modalImg.src = src;
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
    }

    // Fechar modal com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
</script>

@endsection
