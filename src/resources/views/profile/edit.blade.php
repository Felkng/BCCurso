@extends('layouts.main')

@section('title', 'Editar Perfil')

@section('content')
<div class="custom-container">
    <div>
        <div>
            <i class="fas fa-user-edit fa-2x"></i>
            <h3 class="smaller-font">Editar Perfil</h3>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="space-y-6">
                <!-- Informações do Perfil -->
                <div class="card">
                    <div class="card-header text-white div-form">
                        <i class="fas fa-user-circle"></i> Informações do Perfil
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Informações do Professor -->
                <div class="card mt-4">
                    <div class="card-header text-white div-form">
                        <i class="fas fa-chalkboard-teacher"></i> Informações do Professor
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-professor-info-form')
                    </div>
                </div>

                <!-- Alterar Senha -->
                <div class="card mt-4">
                    <div class="card-header text-white div-form">
                        <i class="fas fa-lock"></i> Alterar Senha
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Excluir Conta -->
                <div class="card mt-4">
                    <div class="card-header text-white" style="background-color: #dc3545;">
                        <i class="fas fa-exclamation-triangle"></i> Exclusão de Conta
                    </div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
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
