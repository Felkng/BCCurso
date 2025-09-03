@extends('layouts.main')

@section('title', 'Professores')

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="title-container">
                <div class="page-title">
                    <i class="fas fa-paste fa-2x"></i>
                    <h2>Lista de Professores</h2>
                </div>
                
                <div class="row campo-busca">
                    <div class="col-md-12">
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar em todos os campos"
                            aria-label="Buscar">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="content-card">
            <div class="card-header">
                <span>Professores</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table data-table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Currículo Lattes</th>
                                        <th>Titulação</th>
                                        <th>Biografia</th>
                                        <th>Área</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        @php
                                            $servidor = $user->servidor;
                                            $professor = $servidor ? $servidor->professor : null;
                                        @endphp
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->curriculo_lattes }}</td>
                                            <td>{{ $professor ? $professor->titulacao : 'N/A' }}</td>
                                            <td>{{ $professor ? $professor->biografia : 'N/A' }}</td>
                                            <td>{{ $professor ? $professor->area : 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ url()->previous() }}" class="btn custom-button custom-button-castastrar-tcc btn-default">Voltar</a>
    </div>
@stop
