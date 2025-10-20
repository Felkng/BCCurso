<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    
    <!-- jQuery and Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    
    <!-- Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/variables.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modal.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/alerts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index-pages.css') }}" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Alerts JS -->
    <script src="{{ asset('js/alerts.js') }}"></script>
    
    @vite(['resources/js/app.js'])
</head>

<body>
    <!-- ÚNICO HEADER - Header Moderno Integrado -->
    <header class="modern-header-simple">
        <div class="header-single">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg">
                    <!-- Brand -->
                    <a class="navbar-brand brand-container" href="{{ route('postagem.display') }}">
                        <div class="logo-section">
                            <img src="{{ asset('images/logo-criada.png') }}" alt="Logo" class="logo-img">
                            <div class="brand-text">
                                <h1 class="brand-title">IFNMG</h1>
                                <p class="brand-subtitle">Campus Montes Claros</p>
                            </div>
                        </div>
                    </a>

                    <!-- Menu Integrado ao Perfil -->
                    <div class="navbar-nav-right">
                        <!-- Menu Toggle Button (Mobile Only) -->
                        <button class="navbar-toggler custom-menu-toggle d-lg-none" type="button" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-bars"></i>
                        </button>

                        <!-- Navigation Menu - Desktop Only -->
                        <div class="d-none d-lg-flex align-items-center gap-2" id="desktopNav">
                            <a class="nav-link modern-nav-link {{ request()->routeIs('postagem.display') ? 'active' : '' }}" href="{{ route('postagem.display') }}">
                                <i class="fas fa-home"></i>
                                <span>Início</span>
                            </a>
                            <a class="nav-link modern-nav-link {{ request()->routeIs('curso.show') ? 'active' : '' }}" href="{{ route('curso.show', ['id' => '1']) }}">
                                <i class="fas fa-graduation-cap"></i>
                                <span>Curso</span>
                            </a>
                            <a class="nav-link modern-nav-link {{ request()->routeIs('professor.display') ? 'active' : '' }}" href="{{ route('professor.display') }}">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>Professores</span>
                            </a>
                            <a class="nav-link modern-nav-link {{ request()->routeIs('projetos.view') ? 'active' : '' }}" href="{{ route('projetos.view') }}">
                                <i class="fas fa-project-diagram"></i>
                                <span>Projeto</span>
                            </a>
                            <a class="nav-link modern-nav-link {{ request()->routeIs('tcc.display') ? 'active' : '' }}" href="{{ route('tcc.display') }}">
                                <i class="fas fa-graduation-cap"></i>
                                <span>TCC</span>
                            </a>
                            
                            <!-- Menu Administrativo (para coordenadores ou admin) -->
                            @auth
                                @if((method_exists(Auth::user(), 'hasRole') && Auth::user()->hasRole('coordenador')) || Auth::user()->id == 1)
                                    <div class="dropdown">
                                        <a class="nav-link modern-nav-link dropdown-toggle admin-menu {{ 
                                            request()->is('admin/curso*') || 
                                            request()->is('admin/tcc*') || 
                                            request()->is('admin/aluno*') || 
                                            request()->is('admin/banca*') || 
                                            request()->is('admin/projeto*') || 
                                            request()->is('admin/tipo-postagem*') || 
                                            request()->is('admin/disciplina*') || 
                                            request()->is('admin/intencao_matricula*') || 
                                            request()->is('admin/postagem*') || 
                                            request()->is('admin/professor*') ||
                                            request()->routeIs('curso.index') ||
                                            request()->routeIs('curso.create') ||
                                            request()->routeIs('curso.edit') ||
                                            request()->routeIs('tcc.index') ||
                                            request()->routeIs('tcc.create') ||
                                            request()->routeIs('tcc.edit') ||
                                            request()->routeIs('aluno.index') ||
                                            request()->routeIs('aluno.create') ||
                                            request()->routeIs('aluno.edit') ||
                                            request()->routeIs('banca.index') ||
                                            request()->routeIs('banca.create') ||
                                            request()->routeIs('banca.edit') ||
                                            request()->routeIs('projeto.index') ||
                                            request()->routeIs('projeto.create') ||
                                            request()->routeIs('projeto.edit') ||
                                            request()->routeIs('tipo-postagem.index') ||
                                            request()->routeIs('tipo-postagem.create') ||
                                            request()->routeIs('tipo-postagem.edit') ||
                                            request()->routeIs('disciplina.index') ||
                                            request()->routeIs('disciplina.create') ||
                                            request()->routeIs('disciplina.edit') ||
                                            request()->routeIs('intencao_matricula.index') ||
                                            request()->routeIs('postagem.index') ||
                                            request()->routeIs('postagem.create') ||
                                            request()->routeIs('postagem.edit') ||
                                            request()->routeIs('professor.index') ||
                                            request()->routeIs('professor.create') ||
                                            request()->routeIs('professor.edit')
                                            ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-cogs"></i>
                                            <span>Administrar</span>
                                        </a>
                                        <ul class="dropdown-menu modern-dropdown admin-dropdown">
                                            <li class="dropdown-header">Gerenciar Sistema</li>
                                            <li><a class="dropdown-item {{ request()->routeIs('curso.index') ? 'active' : '' }}" href="{{ route('curso.index') }}">
                                                <i class="fa-solid fa-scroll"></i> Curso
                                            </a></li>
                                            <li><a class="dropdown-item {{ request()->routeIs('tcc.index') ? 'active' : '' }}" href="{{ route('tcc.index') }}">
                                                <i class="fas fa-graduation-cap"></i> TCC
                                            </a></li>
                                            <li><a class="dropdown-item {{ request()->routeIs('aluno.index') ? 'active' : '' }}" href="{{ route('aluno.index') }}">
                                                <i class="fas fa-user-graduate"></i> Aluno
                                            </a></li>
                                            <li><a class="dropdown-item {{ request()->routeIs('banca.index') ? 'active' : '' }}" href="{{ route('banca.index') }}">
                                                <i class="fas fa-users"></i> Banca
                                            </a></li>
                                            <li><a class="dropdown-item {{ request()->routeIs('projeto.index') ? 'active' : '' }}" href="{{ route('projeto.index') }}">
                                                <i class="fas fa-project-diagram"></i> Projeto
                                            </a></li>
                                            <li><a class="dropdown-item {{ request()->routeIs('tipo-postagem.index') ? 'active' : '' }}" href="{{ route('tipo-postagem.index') }}">
                                                <i class="fas fa-tags"></i> Tipo Postagem
                                            </a></li>
                                            <li><a class="dropdown-item {{ request()->routeIs('disciplina.index') ? 'active' : '' }}" href="{{ route('disciplina.index') }}">
                                                <i class="fas fa-book"></i> Disciplinas
                                            </a></li>
                                            <li><a class="dropdown-item {{ request()->routeIs('intencao_matricula.index') ? 'active' : '' }}" href="{{ route('intencao_matricula.index') }}">
                                                <i class="fas fa-clipboard-list"></i> Intenção de Matrícula
                                            </a></li>
                                            <li><a class="dropdown-item {{ request()->routeIs('postagem.index') ? 'active' : '' }}" href="{{ route('postagem.index') }}">
                                                <i class="fas fa-newspaper"></i> Postagens
                                            </a></li>
                                            <li><a class="dropdown-item {{ request()->routeIs('professor.index') ? 'active' : '' }}" href="{{ route('professor.index') }}">
                                                <i class="fas fa-chalkboard-teacher"></i> Professores
                                            </a></li>
                                        </ul>
                                    </div>
                                @endif
                            @endauth
                            
                            <!-- Menu de Usuário Integrado -->
                            @auth
                                <div class="dropdown">
                                    <a class="nav-link modern-nav-link user-profile-btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle"></i>
                                        <span>{{ Auth::user()->name }}</span>
                                    </a>
                                    <ul class="dropdown-menu modern-dropdown user-dropdown">
                                        <li><a class="dropdown-item {{ request()->routeIs('favoritos.meus') ? 'active' : '' }}" href="{{ route('favoritos.meus') }}">
                                            <i class="fas fa-heart"></i> Meus Favoritos
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user-edit"></i> Perfil
                                        </a></li>
                                        @if(Auth::user()->hasRole('aluno'))
                                        <li><a class="dropdown-item {{ request()->routeIs('declaracao_intencao_matricula.selecionar_disciplinas') ? 'active' : '' }}" href="{{ route('declaracao_intencao_matricula.selecionar_disciplinas') }}">
                                            <i class="fas fa-clipboard-list"></i> Declarar Intenção de Matrícula
                                        </a></li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item logout-btn">
                                                    <i class="fas fa-sign-out-alt"></i> Sair
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a class="nav-link modern-nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i>
                                    <span>Entrar</span>
                                </a>
                            @endauth
                        </div>

                        <!-- Navigation Menu - Mobile Only -->
                        <div class="collapse navbar-collapse d-lg-none" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link modern-nav-link {{ request()->routeIs('postagem.display') ? 'active' : '' }}" href="{{ route('postagem.display') }}">
                                        <i class="fas fa-home"></i>
                                        <span>Início</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link modern-nav-link {{ request()->routeIs('curso.show') ? 'active' : '' }}" href="{{ route('curso.show', ['id' => '1']) }}">
                                        <i class="fas fa-graduation-cap"></i>
                                        <span>Curso</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link modern-nav-link {{ request()->routeIs('professor.display') ? 'active' : '' }}" href="{{ route('professor.display') }}">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        <span>Professores</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link modern-nav-link {{ request()->routeIs('projetos.view') ? 'active' : '' }}" href="{{ route('projetos.view') }}">
                                        <i class="fas fa-project-diagram"></i>
                                        <span>Projeto</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link modern-nav-link {{ request()->routeIs('tcc.display') ? 'active' : '' }}" href="{{ route('tcc.display') }}">
                                        <i class="fas fa-graduation-cap"></i>
                                        <span>TCC</span>
                                    </a>
                                </li>
                                
                                <!-- Menu Administrativo Mobile (para coordenadores ou admin) -->
                                @auth
                                    @if((method_exists(Auth::user(), 'hasRole') && Auth::user()->hasRole('coordenador')) || Auth::user()->id == 1)
                                        <li class="nav-item dropdown">
                                            <a class="nav-link modern-nav-link dropdown-toggle admin-menu {{ 
                                                request()->is('admin/curso*') || 
                                                request()->is('admin/tcc*') || 
                                                request()->is('admin/aluno*') || 
                                                request()->is('admin/banca*') || 
                                                request()->is('admin/projeto*') || 
                                                request()->is('admin/tipo-postagem*') || 
                                                request()->is('admin/disciplina*') || 
                                                request()->is('admin/intencao_matricula*') || 
                                                request()->is('admin/postagem*') || 
                                                request()->is('admin/professor*') ||
                                                request()->routeIs('curso.index') ||
                                                request()->routeIs('curso.create') ||
                                                request()->routeIs('curso.edit') ||
                                                request()->routeIs('tcc.index') ||
                                                request()->routeIs('tcc.create') ||
                                                request()->routeIs('tcc.edit') ||
                                                request()->routeIs('aluno.index') ||
                                                request()->routeIs('aluno.create') ||
                                                request()->routeIs('aluno.edit') ||
                                                request()->routeIs('banca.index') ||
                                                request()->routeIs('banca.create') ||
                                                request()->routeIs('banca.edit') ||
                                                request()->routeIs('projeto.index') ||
                                                request()->routeIs('projeto.create') ||
                                                request()->routeIs('projeto.edit') ||
                                                request()->routeIs('tipo-postagem.index') ||
                                                request()->routeIs('tipo-postagem.create') ||
                                                request()->routeIs('tipo-postagem.edit') ||
                                                request()->routeIs('disciplina.index') ||
                                                request()->routeIs('disciplina.create') ||
                                                request()->routeIs('disciplina.edit') ||
                                                request()->routeIs('intencao_matricula.index') ||
                                                request()->routeIs('postagem.index') ||
                                                request()->routeIs('postagem.create') ||
                                                request()->routeIs('postagem.edit') ||
                                                request()->routeIs('professor.index') ||
                                                request()->routeIs('professor.create') ||
                                                request()->routeIs('professor.edit')
                                                ? 'active' : '' }}" href="#" role="button">
                                                <i class="fas fa-cogs"></i>
                                                <span>Administrar</span>
                                            </a>
                                            <ul class="dropdown-menu modern-dropdown admin-dropdown">
                                                <li class="dropdown-header">Gerenciar Sistema</li>
                                                <li><a class="dropdown-item {{ request()->routeIs('curso.index') ? 'active' : '' }}" href="{{ route('curso.index') }}">
                                                    <i class="fa-solid fa-scroll"></i> Curso
                                                </a></li>
                                                <li><a class="dropdown-item {{ request()->routeIs('tcc.index') ? 'active' : '' }}" href="{{ route('tcc.index') }}">
                                                    <i class="fas fa-graduation-cap"></i> TCC
                                                </a></li>
                                                <li><a class="dropdown-item {{ request()->routeIs('aluno.index') ? 'active' : '' }}" href="{{ route('aluno.index') }}">
                                                    <i class="fas fa-user-graduate"></i> Aluno
                                                </a></li>
                                                <li><a class="dropdown-item {{ request()->routeIs('banca.index') ? 'active' : '' }}" href="{{ route('banca.index') }}">
                                                    <i class="fas fa-users"></i> Banca
                                                </a></li>
                                                <li><a class="dropdown-item {{ request()->routeIs('projeto.index') ? 'active' : '' }}" href="{{ route('projeto.index') }}">
                                                    <i class="fas fa-project-diagram"></i> Projeto
                                                </a></li>
                                                <li><a class="dropdown-item {{ request()->routeIs('tipo-postagem.index') ? 'active' : '' }}" href="{{ route('tipo-postagem.index') }}">
                                                    <i class="fas fa-tags"></i> Tipo Postagem
                                                </a></li>
                                            <li><a class="dropdown-item {{ request()->routeIs('disciplina.index') ? 'active' : '' }}" href="{{ route('disciplina.index') }}">
                                                <i class="fas fa-book"></i> Disciplinas
                                            </a></li>
                                            <li><a class="dropdown-item {{ request()->routeIs('intencao_matricula.index') ? 'active' : '' }}" href="{{ route('intencao_matricula.index') }}">
                                                <i class="fas fa-clipboard-list"></i> Intenção de Matrícula
                                            </a></li>
                                                <li><a class="dropdown-item {{ request()->routeIs('postagem.index') ? 'active' : '' }}" href="{{ route('postagem.index') }}">
                                                    <i class="fas fa-newspaper"></i> Postagens
                                                </a></li>
                                                <li><a class="dropdown-item {{ request()->routeIs('professor.index') ? 'active' : '' }}" href="{{ route('professor.index') }}">
                                                    <i class="fas fa-chalkboard-teacher"></i> Professores
                                                </a></li>
                                            </ul>
                                        </li>
                                    @endif
                                @endauth
                                
                                <!-- Menu de Usuário Mobile -->
                                @auth
                                    <li class="nav-item dropdown user-menu-mobile">
                                        <a class="nav-link modern-nav-link dropdown-toggle" href="#" role="button">
                                            <i class="fas fa-user-circle"></i>
                                            <span>{{ Auth::user()->name }}</span>
                                        </a>
                                        <ul class="dropdown-menu modern-dropdown user-dropdown">
                                            <li><a class="dropdown-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                                                <i class="fas fa-user-edit"></i> Perfil
                                            </a></li>
                                            @if(Auth::user()->aluno)
                                            <li><a class="dropdown-item {{ request()->routeIs('declaracao_intencao_matricula.selecionar_disciplinas') ? 'active' : '' }}" href="{{ route('declaracao_intencao_matricula.selecionar_disciplinas') }}">
                                                <i class="fas fa-clipboard-list"></i> Declarar Intenção de Matrícula
                                            </a></li>
                                            @endif
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item logout-btn">
                                                        <i class="fas fa-sign-out-alt"></i> Sair
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link modern-nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                            <i class="fas fa-sign-in-alt"></i>
                                            <span>Entrar</span>
                                        </a>
                                    </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- HEADERS DUPLICADOS REMOVIDOS DEFINITIVAMENTE -->
    <!-- O header único está integrado acima no modern-header-simple -->

    @include('layouts.flash-message')

    <div class="container2">
        @yield('content')
    </div>

    @stack('scripts')

    <div class="spacer"></div>

    <!-- Footer -->
    <footer class="modern-footer">
        <div class="footer-content">
            <div class="container">
                <div class="row">
                    <!-- Seção Institucional -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="footer-section institutional-section">
                            <div class="footer-brand">
                                <img src="{{ asset('images/logo-footer.png') }}" alt="Logo" class="footer-logo">
                                <div class="footer-brand-text">
                                    <h4>IFNMG</h4>
                                    <p>Campus Montes Claros</p>
                                </div>
                            </div>
                            <div class="footer-description">
                                Formando profissionais qualificados em Ciência da Computação com excelência acadêmica, inovação tecnológica e compromisso social para o desenvolvimento regional.
                            </div>
                        </div>
                    </div>

                    <!-- Seção de Contato -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="footer-section contact-section">
                            <h5>
                                <i class="fas fa-address-book"></i>
                                Contato
                            </h5>
                            <ul class="contact-list">
                                <li class="contact-item">
                                    <i class="fas fa-map-marker-alt contact-icon"></i>
                                    <div class="contact-details">
                                        <strong>Endereço:</strong>
                                        <span>Rua Dois, 300 - Village do Lago I<br>Montes Claros - MG, CEP 39.404-058</span>
                                    </div>
                                </li>
                                <li class="contact-item">
                                    <i class="fas fa-phone-alt contact-icon"></i>
                                    <div class="contact-details">
                                        <strong>Telefone:</strong>
                                        <span>(38) 2103-4141</span>
                                    </div>
                                </li>
                                <li class="contact-item">
                                    <i class="fas fa-envelope contact-icon"></i>
                                    <div class="contact-details">
                                        <strong>E-mail:</strong>
                                        <a href="mailto:comunicacao.montesclaros@ifnmg.edu.br">comunicacao.montesclaros@ifnmg.edu.br</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Seção de Links -->
                    <div class="col-lg-4 col-md-12 mb-4">
                        <div class="footer-section links-section">
                            <h5>
                                <i class="fas fa-external-link-alt"></i>
                                Links Úteis
                            </h5>
                            <div class="row">
                                <div class="col-6">
                                    <ul class="footer-links">
                                        <li><a href="{{ route('postagem.display') }}">Início</a></li>
                                        <li><a href="{{ route('curso.show', ['id' => '1']) }}">Sobre o Curso</a></li>
                                        <li><a href="{{ route('professor.display') }}">Professores</a></li>
                                        <li><a href="{{ route('tcc.display') }}">TCC</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="social-section">
                                <h6>Siga-nos</h6>
                                <div class="social-links">
                                    <a href="#" class="social-link" title="Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="social-link" title="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="#" class="social-link" title="LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="#" class="social-link" title="YouTube">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <p class="copyright-text">
                            &copy; {{ date('Y') }} Departamento de Ciência da Computação - IFNMG. Todos os direitos reservados.
                        </p>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-logos">
                            <a href="https://www.ifnmg.edu.br/montesclaros" target="_blank" class="no-decoration-link">
                                <img src="{{ asset('images/logo-if-branco2.png') }}" alt="IFNMG Logo" class="if-logo">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function isMobile() {
                return window.innerWidth <= 991;
            }
            
            const menuToggle = document.querySelector('.custom-menu-toggle');
            const mobileMenu = document.querySelector('#navbarNav');
            
            if (menuToggle && mobileMenu) {
                let menuIsOpen = false;
                let isProcessing = false;
                let lastClickTime = 0;
                
                function toggleMenu(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    
                    const now = Date.now();
                    if (now - lastClickTime < 500) {
                        return;
                    }
                    lastClickTime = now;
                    
                    if (isProcessing) {
                        return;
                    }
                    isProcessing = true;
                    
                    if (menuIsOpen) {
                        mobileMenu.classList.remove('show');
                        menuToggle.setAttribute('aria-expanded', 'false');
                        const icon = menuToggle.querySelector('i');
                        if (icon) icon.style.transform = 'rotate(0deg)';
                        menuIsOpen = false;
                    } else {
                        mobileMenu.classList.add('show');
                        menuToggle.setAttribute('aria-expanded', 'true');
                        const icon = menuToggle.querySelector('i');
                        if (icon) icon.style.transform = 'rotate(90deg)';
                        menuIsOpen = true;
                    }
                    
                    setTimeout(function() {
                        isProcessing = false;
                    }, 400);
                }
                
                menuToggle.removeEventListener('click', toggleMenu);
                menuToggle.addEventListener('click', toggleMenu, { once: false, capture: true });
                
                mobileMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
                
                document.addEventListener('click', function(event) {
                    if (isMobile() && 
                        menuIsOpen &&
                        !menuToggle.contains(event.target) && 
                        !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.remove('show');
                        menuToggle.setAttribute('aria-expanded', 'false');
                        const icon = menuToggle.querySelector('i');
                        if (icon) {
                            icon.style.transform = 'rotate(0deg)';
                        }
                        menuIsOpen = false;
                    }
                });
            }
            
            if (isMobile()) {
                const mobileDropdowns = document.querySelectorAll('#navbarNav .nav-item.dropdown');
                
                mobileDropdowns.forEach(function(dropdown) {
                    const toggle = dropdown.querySelector('.dropdown-toggle');
                    const menu = dropdown.querySelector('.dropdown-menu');
                    
                    if (toggle && menu) {
                        if (toggle.classList.contains('active')) {
                            menu.classList.add('show');
                        }
                        
                        toggle.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            
                            mobileDropdowns.forEach(function(otherDropdown) {
                                if (otherDropdown !== dropdown) {
                                    const otherMenu = otherDropdown.querySelector('.dropdown-menu');
                                    if (otherMenu) {
                                        otherMenu.classList.remove('show');
                                    }
                                }
                            });
                            
                            menu.classList.toggle('show');
                        });
                    }
                });
            }
            
            window.addEventListener('resize', function() {
                if (!isMobile() && mobileMenu) {
                    mobileMenu.classList.remove('show');
                    if (menuToggle) {
                        menuToggle.setAttribute('aria-expanded', 'false');
                        const icon = menuToggle.querySelector('i');
                        if (icon) {
                            icon.style.transform = 'rotate(0deg)';
                        }
                    }
                    
                    const allDropdowns = document.querySelectorAll('#navbarNav .dropdown-menu');
                    allDropdowns.forEach(function(menu) {
                        menu.classList.remove('show');
                    });
                }
            });

            if (!isMobile()) {
                const desktopDropdowns = document.querySelectorAll('#desktopNav .dropdown');
                desktopDropdowns.forEach(function(dropdown) {
                    const toggle = dropdown.querySelector('.dropdown-toggle');
                    const menu = dropdown.querySelector('.dropdown-menu');
                    
                    if (toggle && menu && toggle.classList.contains('active')) {
                        dropdown.addEventListener('mouseenter', function() {
                            menu.classList.add('show');
                        });
                        
                        dropdown.addEventListener('mouseleave', function() {
                            menu.classList.remove('show');
                        });
                    }
                });
            }
        });
    </script>

</body>
</html>
