@extends('layouts.main')

@section('title', 'Projetos')

@section('content')
<div class="page-header">
    <div class="container">
        <div class="title-container">
            <div class="page-title">
                <i class="fas fa-envelopes-bulk fa-2x"></i>
                <h2>Gerenciar Projeto</h2>
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
            <span>Projetos</span>
            <a href="{{ route('projeto.create') }}" class="btn-cadastrar">
                <i class="fas fa-plus"></i> Cadastrar
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="projetoTable" class="table data-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Data Inicio</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projetos as $projeto)
                        <tr>
                            <td>
                                <span class="data-title" data-toggle="tooltip" data-placement="top" title="{{ $projeto->titulo }}">
                                    {{ $projeto->titulo }}
                                </span>
                            </td>
                            <td><span class="data-date">{{ date('d/m/Y', strtotime($projeto->data_inicio)) }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('projeto.destroy', $projeto->id) }}">
                                    @csrf
                                    <div class="action-buttons">
                                        <a class="btn-view" href="{{ route('projeto.show', ['id' => $projeto->id]) }}" title="Visualizar">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <input name="_method" type="hidden" value="DELETE">
                                        <a href="{{ route('projeto.edit', $projeto->id) }}" class="btn-edit" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn-delete" title="Excluir" onclick="confirmDeleteGeneric(this.form, 'Deseja realmente excluir este projeto?', '{{ $projeto->titulo }}')">
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
            $("#projetoTable tbody tr").filter(function() {
                // Excluindo a última coluna que é a de ação do filtro
                var rowData = $(this).find("td:not(:last-child)").text().toLowerCase();
                $(this).toggle(rowData.indexOf(searchText) > -1);
            });
        });
    });
</script>

@include('modal.confirmDeleteGeneric')

@stop