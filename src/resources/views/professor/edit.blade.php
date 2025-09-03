@extends('layouts.main')

@section('title', 'Editar Professor')

@section('content')
    <div class="custom-container">
        <div>
            <div>
                <i class="fas fa-person-chalkboard fa-2x"></i>
                <h3 class="smaller-font">Editar Professor</h3>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Ops!</strong> Algo deu errado:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('professor.update', ['id' => $professor->servidor_id]) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label" for="nome">Nome*:</label>
                <input value="{{ old('nome', $professor->servidor->nome) }}" class="form-control" id="nome" name="nome" type="text" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email*:</label>
                <input value="{{ old('email', $professor->servidor->email) }}" class="form-control" id="email" name="email" type="email" required>
            </div>

            <hr>

            <h4>Função de Coordenador</h4>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_coordenador" id="is_coordenador" value="1"
                    @if(($professor->coordenador)) checked @endif
                >
                <label class="form-check-label" for="is_coordenador">
                    É Coordenador de Curso
                </label>
            </div>

            <div id="coordenador-fields" style="{{ old('is_coordenador', $professor->coordenador) ? 'display:block;' : 'display:none;' }}">
                <div class="mb-3">
                    <label for="curso_id" class="form-label">Coordenador do Curso*:</label>
                    <select name="curso_id" id="curso_id" class="form-select">
                        <option value="">Selecione um curso</option>
                        @foreach ($cursos as $curso)
                            <option value="{{ $curso->id }}"
                                @if(old('curso_id', $professor->coordenador->curso_id ?? '') == $curso->id) selected @endif
                            >
                                {{ $curso->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Campos de horário, email e sala --}}
                <div class="mb-3">
                    <label for="horario_atendimento" class="form-label">Horário de Atendimento*</label>
                    <input type="text" class="form-control" id="horario_atendimento" name="horario_atendimento" value="{{ old('horario_atendimento', $professor->coordenador->horario_atendimento ?? '') }}">
                </div>
                <div class="mb-3">
                    <label for="email_contato" class="form-label">Email de Contato do Coordenador*</label>
                    <input type="email" class="form-control" id="email_contato" name="email_contato" value="{{ old('email_contato', $professor->coordenador->email_contato ?? '') }}">
                </div>
                <div class="mb-3">
                    <label for="sala_atendimento" class="form-label">Sala de Atendimento*</label>
                    <input type="text" class="form-control" id="sala_atendimento" name="sala_atendimento" value="{{ old('sala_atendimento', $professor->coordenador->sala_atendimento ?? '') }}">
                </div>
            </div>
            
            <hr>

            <button type="submit" class="btn custom-button btn-default">Salvar</button>
            <a href="{{ route('professor.index') }}" class="btn custom-button custom-button-castastrar-tcc btn-default">Cancelar</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox = document.getElementById('is_coordenador');
            const fields = document.getElementById('coordenador-fields');

            function toggleCoordinatorFields() {
                fields.style.display = checkbox.checked ? 'block' : 'none';
            }

            toggleCoordinatorFields();

            checkbox.addEventListener('change', toggleCoordinatorFields);
        });
    </script>
@stop