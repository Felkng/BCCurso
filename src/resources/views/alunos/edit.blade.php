@extends('layouts.main')

@section('title', 'Editar Aluno')

@section('content')
    <div class="custom-container">
        <div>
            <div>
                <i class="fas fa-paste fa-2x"></i>
                <h3 class="smaller-font">Editar Aluno</h3>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <form method="post" action="{{ route('aluno.update', ['aluno' => $aluno->id]) }}">
            @csrf
            @method('PUT')

            <div class="form-group">

                <label for="nome" class="form-label">Nome*:</label>
                <input value="{{ old('nome') ?? $aluno->nome }}" type="text" name="nome" id="nome" placeholder="Nome do aluno" required class="form-control @error('nome') is-invalid @enderror">

                @error('nome')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="matricula" class="form-label">Matrícula*:</label>
                <input value="{{ old('matricula') ?? $aluno->matricula}}" type="text" name="matricula" id="matricula" placeholder="Número da matrícula" required class="form-control @error('matricula') is-invalid @enderror">

                @error('matricula')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit" class="btn custom-button btn-default">Salvar</button>
            <a href="{{ route('aluno.index') }} "
                class="btn custom-button custom-button-castastrar-tcc btn-default">Cancelar</a>
        </form>
    </div>
@stop
