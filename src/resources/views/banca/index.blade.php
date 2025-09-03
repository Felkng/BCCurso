@extends('layouts.main')

@section('title', 'Banca')

@section('content')
<div class="page-header">
    <div class="container">
        <div class="title-container">
            <div class="page-title">
                <i class="fas fa-chalkboard fa-2x"></i>
                <h2>Gerenciar Banca</h2>
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
            <span>Banca</span>
            <a href="{{ route('banca.create') }}" class="btn btn-cadastrar">
                <i class="fas fa-plus"></i> Cadastrar
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="bancaTable" class="table data-table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Local</th>
                            <th>Membros</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                        <tbody>
                            @foreach ($bancas as $banca)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($banca->data)) }}</td>
                                <td class="text-wrap">{{ $banca->local }}</td>
                                <td class="text-wrap">
                                    <span style="font-weight: bold;"> Presidente da banca:</span><br>
                                    <span>{{ $banca->presidente->servidor->nome }}</span><br>

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
                                    <span>{{ $professor->servidor->nome }}</span>
                                    <br>


                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a class="btn-view" href="{{ route('banca.show', ['id' => $banca->id]) }}"><i class="fa-solid fa-eye"></i></a>
                                        <a href="{{ route('banca.edit', $banca->id) }}" class="btn-edit"><i class="fas fa-pencil-alt"></i></a>
                                        <form method="POST" action="{{ route('banca.destroy', $banca->id) }}" style="display: inline;">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="button" class="btn-delete" title='Delete' onclick="confirmDeleteGeneric(this.form, 'Deseja realmente excluir esta banca?', 'Banca do TCC: {{ $banca->tcc->titulo ?? "N/A" }}')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#searchInput").on("keyup", function() {
            var searchText = $(this).val().toLowerCase();
            $("#bancaTable tbody tr").filter(function() {
                // Excluindo a última coluna que é a de ação do filtro
                var rowData = $(this).find("td:not(:last-child)").text().toLowerCase();
                $(this).toggle(rowData.indexOf(searchText) > -1);
            });
        });
    });
</script>

@include('modal.confirmDeleteGeneric')

@stop
