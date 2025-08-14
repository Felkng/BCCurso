@extends('layouts.main')
@section('title', 'TCC')
@section('content')

<style>
    /* Barra lateral */
    .post-sidebar {
        margin-top: 1rem;
    }
    
    .sidebar-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .sidebar-header {
        background-color: #2c3e50;
        color: white;
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }
    
    .sidebar-header i {
        color: #74b9ff;
    }
    
    .sidebar-body {
        padding: 1.5rem;
    }
</style>

<div class="custom-container">
    <div>
        <div>
            <i class="fas fa-graduation-cap fa-2x"></i>
            <h3 class="smaller-font">TCC</h3>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="main-body">
        <div class="row gutters-sm">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Título:</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{$tcc->titulo}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Ano:</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{$tcc->ano}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Resumo:</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {!! nl2br(str_replace(' ', '&nbsp;', e($tcc->resumo))) !!}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Aluno:</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{$aluno->nome}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Orientador:</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{$orientador->nome}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Local da Banca:</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{$banca->local}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Data da Banca:</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ date('d/m/Y', strtotime($banca->data)) }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Professores Banca: </h6>
                            </div>
                            <div class="col-sm-9 text-secondary">

                                @if (count($banca->professoresExternos) > 0)
                                <span style="font-weight: bold;"> Professores Externos:</span><br>
                                @foreach ($banca->professoresExternos as $professor_externo)
                                <span>{{ $professor_externo->nome }} - {{ $professor_externo->filiacao }}
                                </span><br>
                                @endforeach
                                <br>
                                @endif

                                @if (count($banca->professores) > 0)
                                <span style="font-weight: bold;"> Professores Internos:</span><br>
                                @foreach ($banca->professores as $professor)
                                <span>{{ $professores_internos->contains($professor->id) ? $professores_internos->where('id', $professor->id)->first()->nome: '' }} </span>
                                <span>{!! $professores_internos->contains($professor->id) ? '<br>' : '' !!}</span>
                                @endforeach
                                @endif

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Status: </h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $tcc->status == 0 ? "Aguardando defesa" : "Concluido"}}
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Arquivo: </h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                @if($tcc->arquivo)
                                <a href="{{ URL::asset('storage') }}/{{ $tcc->arquivo->path }}" download class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-download"></i> {{ $tcc->arquivo->nome }}
                                </a>
                                @else
                                <span class="text-muted">Não há arquivo cadastrado!</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="post-sidebar">
                    @auth
                    <!-- Botão de Favoritar -->
                    <div class="sidebar-card">
                        <div class="sidebar-header">
                            <i class="fas fa-heart"></i> Favoritar TCC
                        </div>
                        <div class="sidebar-body text-center">
                            <form method="POST" action="{{ route('favoritos.toggle') }}" id="favoritoForm">
                                @csrf
                                <input type="hidden" name="type" value="tcc">
                                <input type="hidden" name="id" value="{{ $tcc->id }}">
                                <button type="submit" 
                                        class="btn {{ Auth::user()->jaFavoritou($tcc) ? 'btn-danger' : 'btn-outline-danger' }} btn-lg w-100 mb-3">
                                    <i class="fas fa-heart"></i>
                                    {{ Auth::user()->jaFavoritou($tcc) ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos' }}
                                </button>
                            </form>
                            <small class="text-muted">
                                <i class="fas fa-heart text-danger"></i> {{ $tcc->totalFavoritos() }} pessoa(s) favoritaram este TCC
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
                    @else
                    <!-- Área para usuários não logados -->
                    <div class="sidebar-card">
                        <div class="sidebar-body text-center py-4">
                            <i class="fas fa-sign-in-alt fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Faça login para favoritar</h6>
                            <p class="text-muted mb-3 small">Para favoritar este TCC, você precisa estar logado.</p>
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Fazer Login
                            </a>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-center mt-4">
    <a href="{{ route('tcc.display') }}" class="btn custom-button custom-button-castastrar-tcc btn-default">Voltar</a>
</div>

@stop