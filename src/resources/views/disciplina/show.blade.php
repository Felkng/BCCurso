@extends('layouts.main')

@section('title', 'Detalhes da Disciplina')

@section('content')
<div class="custom-container">
    <div>
        <div>
            <i class="fas fa-book fa-2x"></i>
            <h3 class="smaller-font">Detalhes da Disciplina</h3>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $disciplina->nome }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID:</strong> {{ $disciplina->id }}</p>
                    <p><strong>Nome:</strong> {{ $disciplina->nome }}</p>
                    @if($disciplina->optativa)
                        <p><strong>Tipo:</strong> <span class="badge bg-info">Optativa</span></p>
                    @else
                        <p><strong>Período:</strong> {{ $disciplina->periodo }}º</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <p><strong>Criado em:</strong> {{ $disciplina->created_at->format('d/m/Y H:i:s') }}</p>
                    <p><strong>Atualizado em:</strong> {{ $disciplina->updated_at->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex gap-2">
            <a href="{{ route('disciplina.index') }}" class="btn custom-button custom-button-castastrar-tcc">
            <i class="fas fa-arrow-left"></i> Voltar
            </a>
            <form action="{{ route('disciplina.destroy', $disciplina->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta disciplina?')">
                    <i class="fas fa-trash"></i> Excluir
                </button>
            </form>
        </div>
    </div>
</div>
@stop