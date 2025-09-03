@extends('layouts.main')

@section('title', 'Editar Perfil - Aluno')

@section('content')
<div class="custom-container">
    <div>
        <div>
            <i class="fas fa-user-edit fa-2x"></i>
            <h3 class="smaller-font">Editar Perfil</h3>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="space-y-6">
                <!-- Informações do Perfil -->
                <div class="card">
                    <div class="card-header text-white div-form">
                        <i class="fas fa-user-circle"></i> Informações do Perfil
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-aluno-form')
                    </div>
                </div>

                <!-- Alterar Senha - Apenas para Alunos -->
                <div class="card mt-4">
                    <div class="card-header text-white div-form">
                        <i class="fas fa-lock"></i> Alterar Senha
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-aluno-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="{{ url()->previous() }}" class="btn custom-button custom-button-castastrar-tcc btn-default">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>
@endsection
