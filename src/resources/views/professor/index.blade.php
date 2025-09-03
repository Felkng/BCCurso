@extends('layouts.main')

@section('title', 'Professores')

@section('content')
<div class="page-header">
    <div class="container">
        <div class="title-container">
            <div class="page-title">
                <i class="fas fa-person-chalkboard fa-2x"></i>
                <h2>Gerenciar Professor</h2>
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
            <span>Professores</span>
            <a href="{{ route('professor.create') }}" class="btn-cadastrar">
                <i class="fas fa-plus"></i> Cadastrar
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="professorTable" class="table data-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Criação</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($servidores as $servidor)
                        <tr>
                            <td>
                                <span class="data-title" data-toggle="tooltip" data-placement="top" title="{{ $servidor->nome }}">
                                    {{ $servidor->nome }}
                                </span>
                            </td>
                            <td>{{ $servidor->email }}</td>
                            <td><span class="data-date">{{ date_format($servidor->created_at, 'd/m/Y H:i:s') }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('professor.destroy', $servidor->id) }}">
                                    @csrf
                                    <div class="action-buttons">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <a class="btn-view" href="{{ route('professor.view', ['id' => $servidor->id]) }}" title="Visualizar">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a class="btn-edit" href="{{ route('professor.edit', $servidor->id) }}" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn-delete" title="Excluir" onclick="confirmDeleteGeneric(this.form, 'Deseja realmente excluir este professor?', '{{ $servidor->nome }}')">
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

<script>
    $(document).ready(function() {
        $("#searchInput").on("keyup", function() {
            var searchText = $(this).val().toLowerCase();
            $("#professorTable tbody tr").filter(function() {
                // Excluindo a última coluna que é a de ação do filtro
                var rowData = $(this).find("td:not(:last-child)").text().toLowerCase();
                $(this).toggle(rowData.indexOf(searchText) > -1);
            });
        });
    });
</script>

@include('modal.confirmDeleteGeneric')

@stop