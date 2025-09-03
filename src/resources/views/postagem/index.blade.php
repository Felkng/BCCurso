@extends('layouts.main')

@section('title', 'Postagens')

@section('content')

<div class="page-header">
    <div class="container">
        <div class="title-container">
            <div class="page-title">
                <i class="fas fa-newspaper fa-2x"></i>
                <h2>Gerenciar Postagens</h2>
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
            <span>Postagens</span>
            <a href="{{ route('postagem.create') }}" class="btn-cadastrar">
                <i class="fas fa-plus"></i> Cadastrar
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="postagemTable" class="table data-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Criação</th>
                            <th>Ação</th>
                            <th>Fixar</th>
                        </tr>
                    </thead>
                            <tbody>
                        @foreach ($postagens as $postagem)
                        <tr class="{{ $postagem->isPinned() ? 'pinned-row' : '' }}">
                            <td>
                                <span class="data-title" data-toggle="tooltip" data-placement="top" title="{{ $postagem->titulo }}">
                                    {{ $postagem->titulo }}
                                </span>
                                @if($postagem->isPinned())
                                    <i class="fas fa-thumbtack pinned-indicator" title="Notícia fixada"></i>
                                @endif
                            </td>
                            <td>
                                <span class="data-date">{{ date_format($postagem->created_at, 'd/m/Y H:i:s') }}</span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('postagem.destroy', $postagem->id) }}">
                                    @csrf
                                    <div class="action-buttons">
                                        <a class="btn-view" href="{{ route('postagem.show', ['id' => $postagem->id]) }}" title="Visualizar">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <input name="_method" type="hidden" value="DELETE">
                                        <a href="{{ route('postagem.edit', $postagem->id) }}" class="btn-edit" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn-delete" title="Excluir" onclick="confirmDeleteGeneric(this.form, 'Deseja realmente excluir esta postagem?', '{{ $postagem->titulo }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <div class="pin-checkbox-container">
                                    <input class="form-check-input pin-checkbox" type="checkbox"
                                           id="pinPost{{ $postagem->id }}"
                                           data-post-id="{{ $postagem->id }}"
                                           {{ $postagem->isPinned() ? 'checked' : '' }}>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#searchInput").on("keyup", function() {
            var searchText = $(this).val().toLowerCase();
            $("#postagemTable tbody tr").filter(function() {
                // Excluindo a última coluna que é a de ação do filtro
                var rowData = $(this).find("td:not(:last-child)").text().toLowerCase();
                $(this).toggle(rowData.indexOf(searchText) > -1);
            });
        });
    });

    const checkboxes = document.querySelectorAll('.pin-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const postId = this.dataset.postId;
            const isChecked = this.checked;
            const url = `{{ url('/postagens') }}/${postId}/toggle-pin`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    console.log(data.message);
                } else {
                    console.error('Erro ao alternar o status de fixação:', data.message);
                    this.checked = false;
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
                this.checked = !isChecked;
            });
        });
    });
</script>

@include('modal.confirmDeleteGeneric')

@stop
