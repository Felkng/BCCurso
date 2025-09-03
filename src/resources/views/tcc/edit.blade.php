@extends('layouts.main')
@section('title', 'Editar TCC')
@section('content')

<div class="custom-container">
    <div>
        <div>
            <i class="fas fa-graduation-cap fa-2x"></i>
            <h3 class="smaller-font">Editar TCC</h3>
        </div>
    </div>
</div>

<div class="container mt-4">

    <div class="card-body">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="post" action="{{ route('tcc.update', [$tcc->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <h5 class="card-title mb-3">Informações Gerais</h5>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título*:</label>
                            <input type="text" name="titulo" id="titulo"
                                class="form-control @error('titulo') is-invalid @enderror" placeholder="Título do TCC"
                                value="{{ $tcc->titulo }}" required>
                            @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="resumo" class="form-label">Resumo*:</label>
                            <textarea name="resumo" id="resumo"
                                class="form-control @error('resumo') is-invalid @enderror" rows="4"
                                placeholder="Resumo do TCC" required>{{ $tcc->resumo }}</textarea>
                            @error('resumo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <h5 class="card-title mb-3">Participantes e Banca</h5>
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label for="aluno_id" class="form-label">Aluno*:</label>
                                <select name="aluno_id" id="aluno_id"
                                    class="form-select @error('aluno_id') is-invalid @enderror" required>
                                    <option value="" disabled>Selecione um aluno</option>
                                    @foreach ($alunos as $aluno)
                                    <option value="{{ $aluno->id }}" {{ $aluno->id == $tcc->aluno_id ? 'selected' : '' }}>
                                        {{ $aluno->nome }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('aluno_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2 text-center">
                                    <a href="#" class="btn btn-info modal-trigger" data-bs-toggle="modal"
                                        data-bs-target="#createAluno">Cadastrar aluno</a>
                                </div>

                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="professor_id" class="form-label">Orientador*:</label>
                                <select name="professor_id" id="professor_id"
                                    class="form-select @error('professor_id') is-invalid @enderror" required>
                                    <option value="" disabled>Selecione um orientador</option>
                                    @foreach ($professores as $professor)
                                    <option value="{{ $professor->id }}" {{ $professor->id == $tcc->professor_id ? 'selected' : '' }}>
                                        {{ $professor->nome }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('professor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2 text-center">
                                    <a href="#" class="btn btn-info modal-trigger" data-bs-toggle="modal"
                                        data-bs-target="#createProfessor">Cadastrar professor</a>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="banca_id" class="form-label">Banca*:</label>
                                <select name="banca_id" id="banca_id"
                                    class="form-select @error('banca_id') is-invalid @enderror" required>
                                    <option value="" disabled>Selecione uma banca</option>
                                    @foreach ($bancas as $banca)
                                    <option value="{{ $banca->id }}" {{ $banca->id == $tcc->banca_id ? 'selected' : '' }}>
                                        {{ date('d/m/Y', strtotime($banca->data)) }} - {{ $banca->local }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('banca_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2 text-center">
                                    <a href="#" class="btn btn-info modal-trigger" data-bs-toggle="modal"
                                        data-bs-target="#createBanca">Cadastrar banca</a>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="card-title mb-3">Detalhes Finais</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ano" class="form-label">Ano*:</label>
                                <input type="number" name="ano" id="ano"
                                    class="form-control @error('ano') is-invalid @enderror" min="2013"
                                    value="{{ $anoTcc }}" required>
                                @error('ano')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status*:</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="0" {{ $tcc->status == 0 ? 'selected' : '' }}>Aguardando defesa</option>
                                    <option value="1" {{ $tcc->status == 1 ? 'selected' : '' }}>Concluído</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3" id="arquivo_id" style="{{ $tcc->status == 1 ? 'display: block;' : 'display: none;' }}">
                            <label for="arquivo" class="form-label">Arquivo (Versão Final):</label>
                            @if ($tcc->status == 1 && $tcc->arquivo)
                                <div class="mb-2">
                                    <small class="text-muted">Arquivo atual: </small>
                                    <a href="{{ asset($tcc->arquivo->path) }}" download class="text-primary">{{ $tcc->arquivo->nome }}</a>
                                </div>
                            @endif
                            <input type="file" name="arquivo" id="arquivo" class="form-control">
                            <small class="text-muted">Deixe em branco para manter o arquivo atual.</small>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit"
                                class="btn custom-button custom-button-castastrar-tcc btn-default">Salvar
                                Alterações</button>
                            <a href="{{ route('tcc.index') }}"
                                class="btn custom-button custom-button-castastrar-tcc btn-default">Cancelar</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@include('modal.createAluno')
@include('modal.createBanca')
@include('modal.createProfessor')

<script>
document.addEventListener("DOMContentLoaded", function() {
    var statusSelect = document.getElementById("status");
    var arquivo = document.getElementById("arquivo_id");

    statusSelect.addEventListener("change", function() {
        if (statusSelect.value === "1") {
            arquivo.style.display = "block";
        } else {
            arquivo.style.display = "none";
        }
    });
});
</script>

@endsection
