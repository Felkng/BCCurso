@extends('layouts.main')

@section('title', 'Alunos')

@section('content')
<div class="page-header">
    <div class="container">
        <div class="title-container">
            <div class="page-title">
                <i class="fas fa-paste fa-2x"></i>
                <h2>Gerenciar Alunos</h2>
            </div>
            
            <div class="row campo-busca">
                <div class="col-md-12">
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar em todos os campos" aria-label="Buscar">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="content-card">
        <div class="card-header">
            <span>Alunos</span>
            <a href="{{ route('aluno.create') }}" class="btn-cadastrar">
                <i class="fas fa-plus"></i> Cadastrar
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="alunosTable" class="table data-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Matrícula</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alunos as $aluno)
                        <tr>
                            <td>
                                <span class="data-title" data-toggle="tooltip" data-placement="top" title="{{ $aluno->nome }}">
                                    {{ $aluno->nome }}
                                </span>
                            </td>
                            <td>{{ $aluno->user->email }}</td>
                            <td>{{ $aluno->matricula }}</td>
                            <td>
                                <form method="POST" action="{{ route('aluno.destroy', $aluno->id) }}">
                                    @csrf
                                    <div class="action-buttons">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <a href="{{ route('aluno.edit', $aluno->id) }}" class="btn-edit" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn-delete" title="Excluir" onclick="confirmDeleteGeneric(this.form, 'Deseja realmente excluir este aluno?', '{{ $aluno->nome }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#searchInput").on("keyup", function() {
            var searchText = $(this).val().toLowerCase();
            $("#alunosTable tbody tr").filter(function() {
                // Excluindo a última coluna que é a de ação do filtro
                var rowData = $(this).find("td:not(:last-child)").text().toLowerCase();
                $(this).toggle(rowData.indexOf(searchText) > -1);
            });
        });
    });
</script>

@include('modal.confirmDeleteGeneric')

@stop
