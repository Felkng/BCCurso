@extends('layouts.main')

@section('title', 'Colegiado')

@section('content')
<div class="page-header">
    <div class="container">
        <div class="title-container">
            <div class="page-title">
                <i class="fas fa-paste fa-2x"></i>
                <h2>Colegiado</h2>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('colegiado.create') }}" class="btn btn-cadastrar">
            <i class="fas fa-plus"></i> Novo colegiado
        </a>
        <a href="{{ route('ata.create') }}" class="btn btn-cadastrar">
            <i class="fas fa-plus"></i> Nova ata
        </a>
    </div>

    <div class="content-card">
        <div class="card-header">
            <div>
                <span>Colegiado Atual</span>
                <div>
                    <strong>
                        Portaria vigente:
                        {{ $colegiado_atual ? 'Nº ' . $colegiado_atual->numero_portaria : 'Sem portaria vigente' }}
                    </strong>
                </div>
                <div>
                    {{ $colegiado_atual
                                ? 'De ' .
                                    date('d/m/Y', strtotime($colegiado_atual->inicio)) .
                                    ' até ' .
                                    date('d/m/Y', strtotime($colegiado_atual->fim))
                                : '-' }}
                </div>
                <div id="pdf">
                    @if ($colegiado_atual && $colegiado_atual->arquivoPortaria)
                    <a href="{{ URL::asset('storage') }}/{{ $colegiado_atual->arquivoPortaria->path }}" download style="color: #0088ff;">Download
                        portaria Nº {{ $colegiado_atual->numero_portaria }}</a>
                    @else
                    Sem arquivo de portaria disponível
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if ($colegiado_atual != null)
            <div class="p-3">
                <div class="action-buttons">
                    <a href="{{ route('colegiado.edit', $colegiado_atual->id) }}" class="btn-edit"><i class="fas fa-pencil-alt"></i></a>
                    <form method="POST" action="{{ route('colegiado.destroy', $colegiado_atual->id) }}" style="display: inline;">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button type="button" class="btn-delete" title='Delete' onclick="confirmDeleteGeneric(this.form, 'Deseja realmente excluir este colegiado?', 'Colegiado atual')"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
            @endif

            <div class="table-responsive p-3">
                <h5>Membros</h5>
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>Presidente</th>
                            <th>Docentes</th>
                            <th>Discentes</th>
                            <th>Técnico administrativo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $colegiado_atual ? $colegiado_atual->presidente->servidor->nome : '-' }}</td>
                            <td>
                                @if ($colegiado_atual)
                                @foreach ($colegiado_atual->professores as $professor)
                                <p>{{ $professor->servidor->nome }}</p>
                                @endforeach
                                @endif
                            </td>
                            <td>
                                @if ($colegiado_atual)
                                @foreach ($colegiado_atual->alunos as $aluno)
                                <p>{{ $aluno->nome }}</p>
                                @endforeach
                                @endif
                            </td>
                            <td>
                                @if ($colegiado_atual)
                                @foreach ($colegiado_atual->tecnicosAdm as $tecnicoAdm)
                                <p>{{ $tecnicoAdm->nome }}</p>
                                @endforeach
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="table-responsive p-3">
                <h5>Atas</h5>
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($colegiado_atual != null && $colegiado_atual->atas)
                        @foreach ($colegiado_atual->atas as $ata)
                        <tr>
                            <td>
                                <a href="" class="data-title" data-bs-toggle="modal" data-bs-target="#showAta_{{ $ata->id }}">{{ date('d/m/Y', strtotime($ata->data)) }}</a>
                            </td>
                            @include('ata.show')
                            <td>
                                <div class="action-buttons">
                                    <a class="btn-view" href="{{ route('ata.show', ['id' => $ata->id]) }}"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('ata.edit', $ata->id) }}" class="btn-edit"><i class="fas fa-pencil-alt"></i></a>
                                    <form method="POST" action="{{ route('ata.destroy', $ata->id) }}" style="display: inline;">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit" class="btn-delete" title='Delete' onclick="return confirm('Deseja realmente excluir esse registro?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($colegiados != null)
    @foreach ($colegiados as $colegiado)
    <div class="content-card mt-4">
        <div class="card-header">
            <div>
                <span>Portaria Nº {{ $colegiado->numero_portaria }}</span>
                <div>
                    {{ $colegiado ? 'De ' . date('d/m/Y', strtotime($colegiado->inicio)) . ' até ' . date('d/m/Y', strtotime($colegiado->fim)) : '-' }}
                </div>
                <div id="pdf">
                    @if ($colegiado && $colegiado->arquivoPortaria)
                    <a href="{{ URL::asset('storage') }}/{{ $colegiado->arquivoPortaria->path }}" download style="color: #0088ff;">Download
                        portaria Nº {{ $colegiado->numero_portaria }}</a>
                    @else
                    Sem arquivo de portaria disponível
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if ($colegiado != null)
            <div class="p-3 d-flex justify-content-between">
                <div class="action-buttons">
                    <a href="{{ route('colegiado.edit', $colegiado->id) }}" class="btn-edit"><i class="fas fa-pencil-alt"></i></a>
                    <form method="POST" action="{{ route('colegiado.destroy', $colegiado->id) }}" style="display: inline;">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button type="button" class="btn-delete" title='Delete' onclick="confirmDeleteGeneric(this.form, 'Deseja realmente excluir este colegiado histórico?', 'Colegiado de {{ $colegiado->incio }} a {{ $colegiado->fim }}')"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
                
                <form action="{{ route('colegiado.update', [ $colegiado->id, 'update_to_atual' => '1']) }}" method="post">
                    @method('PUT')
                    @csrf
                    <button class="btn btn-cadastrar" type="submit" {{ $colegiado->incio < now() && $colegiado->fim > now() ? '' : 'disabled' }}>
                        Tornar atual
                    </button>
                </form>
            </div>
            @endif

            <div class="table-responsive p-3">
                <h5>Membros</h5>
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>Presidente</th>
                            <th>Docentes</th>
                            <th>Discentes</th>
                            <th>Técnico administrativo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $colegiado ? $colegiado->presidente->servidor->nome : '-' }}</td>
                            <td>
                                @if ($colegiado)
                                @foreach ($colegiado->professores as $professor)
                                <p>{{ $professor->servidor->nome }}</p>
                                @endforeach
                                @endif
                            </td>
                            <td>
                                @if ($colegiado)
                                @foreach ($colegiado->alunos as $aluno)
                                <p>{{ $aluno->nome }}</p>
                                @endforeach
                                @endif
                            </td>
                            <td>
                                @if ($colegiado)
                                @foreach ($colegiado->tecnicosAdm as $tecnicoAdm)
                                <p>{{ $tecnicoAdm->nome }}</p>
                                @endforeach
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="table-responsive p-3">
                <h5>Atas</h5>
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($colegiado != null && $colegiado->atas)
                        @foreach ($colegiado->atas as $ata)
                        <tr>
                            <td>
                                <a href="" class="data-title" data-bs-toggle="modal" data-bs-target="#showAta_{{ $ata->id }}">{{ date('d/m/Y', strtotime($ata->data)) }}</a>
                            </td>
                            @include('ata.show')
                            <td>
                                <div class="action-buttons">
                                    <a class="btn-view" href="{{ route('ata.show', ['id' => $ata->id]) }}"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('ata.edit', $ata->id) }}" class="btn-edit"><i class="fas fa-pencil-alt"></i></a>
                                    <form method="POST" action="{{ route('ata.destroy', $ata->id) }}" style="display: inline;">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit" class="btn-delete" title='Delete' onclick="return confirm('Deseja realmente excluir esse registro?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>

@stop
