@extends('layouts.main')

@section('title', 'Cursos')

@section('content')
<div class="page-header">
    <div class="container">
        <div class="title-container">
            <div class="page-title">
                <i class="fas fa-person-chalkboard fa-2x"></i>
                <h2>Gerenciar Cursos</h2>
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
            <span>Cursos</span>
            {{-- <a href="{{ route('curso.create') }}" class="btn-cadastrar">
                <i class="fas fa-plus"></i> Cadastrar
            </a> --}}
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="cursoTable" class="table data-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Sigla</th>
                            <th>Turno</th>
                            <th>Carga Horária</th>
                            <th>Calendario</th>
                            <th>Horario</th>
                            <th>Criação</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cursos as $curso)
                        <tr>
                            <td>
                                <span class="data-title" data-toggle="tooltip" data-placement="top" title="{{ $curso->nome }}">
                                    {{ $curso->nome }}
                                </span>
                            </td>
                            <td>{{ $curso->sigla }}</td>
                            <td>{{ $curso->turno }}</td>
                            <td>{{ $curso->carga_horaria }} Hrs</td>
                            <td>
                                @if ($curso->calendario)
                                <a href="{{ route('curso.download_calendario', ['id' => $curso->id]) }}" class="btn btn-primary btn-sm">Baixar Calendário</a>
                                @endif
                            </td>
                            <td>
                                @if ($curso->horario)
                                <a href="{{route('curso.download_horario',['id'=>$curso->id]) }}" class="btn btn-primary btn-sm">Baixar Horário</a>
                                @endif
                            </td>
                            <td><span class="data-date">{{ date_format($curso->created_at, 'd/m/Y H:i:s') }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('curso.destroy', $curso->id) }}">
                                    @csrf
                                    <div class="action-buttons">
                                        <a class="btn-view" href="{{ route('curso.show', ['id' => $curso->id]) }}" title="Visualizar">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        {{-- <input name="_method" type="hidden" value="DELETE"> --}}
                                        <a class="btn-edit" href="{{ route('curso.edit', $curso->id) }}" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        {{-- <button type="submit" class="btn-delete" title="Excluir" onclick="return confirm('Deseja realmente excluir esse curso?')"><i class="fas fa-trash"></i></button>
                                        <a class="btn-edit" href="{{ route('curso.coordenador', $curso->id) }}">Coordenador</a> --}}
                                        <a href="{{ route('ppc.index', ['cursoId' => $curso->id]) }}" class="btn-edit" title="Ver PPCs">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
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
            $("#cursoTable tbody tr").filter(function() {
                // Excluindo a última coluna que é a de ação do filtro
                var rowData = $(this).find("td:not(:last-child)").text().toLowerCase();
                $(this).toggle(rowData.indexOf(searchText) > -1);
            });
        });
    });
</script>
@stop