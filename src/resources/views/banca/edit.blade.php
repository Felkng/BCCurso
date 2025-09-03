@extends('layouts.main')

@section('title', 'Editar Banca')

@section('content')
<div class="custom-container">
    <div>
        <div>
            <i class="fas fa-pencil-alt fa-2x"></i>
            <h3 class="smaller-font">Editar Banca</h3>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('banca.update', $banca->id) }}">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="data" class="form-label fw-bold">Data da banca*:</label>
                        <input type="date" name="data" id="data" class="form-control" value="{{ $banca->data }}" required>
                    </div>
                    <div class="col-md-8">
                        <label for="local" class="form-label fw-bold">Local*:</label>
                        <input type="text" name="local" id="local" class="form-control" value="{{ $banca->local }}" placeholder="Ex: Sala 201 ou link da chamada" required>
                    </div>
                </div>

                <hr>

                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="mb-3">Membros Internos</h5>
                        
                        <div class="form-group" id="professores">
                            <label for="presidente" class="form-label fw-bold">Presidente*:</label>
                            <select name="presidente" id="presidente" class="form-select" required>
                                <option value="" disabled selected>Selecione um presidente para a banca</option>
                                @foreach ($professores_internos as $professor)
                                <option value="{{ $professor->id }}" data-professor-id="{{ $professor->id }}"> {{ $professor->nome }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" id="professores">
                            <label for="professores" class="form-label">Professores internos:</label>
                        <a href="#" class="btn btn-outline-primary btn-sm py-0" data-bs-toggle="modal" data-bs-target="#createProfessor">
                                    <i class="fas fa-plus fa-xs"></i> Novo
                                </a>
                                @foreach ($professores_internos as $professor_interno)
                                <div class="form-check">
                                    {{-- Adiciona o atributo 'checked' se o professor já estiver na banca --}}
                                    <input type="checkbox" class="form-check-input" name="professores_internos[]" id="professor_{{$professor_interno->id}}" value="{{$professor_interno->id}}"
                                        {{ $banca->professores->contains($professor_interno->id) ? 'checked' : '' }}>
                                    <label for="professor_{{$professor_interno->id}}" class="form-check-label">{{$professor_interno->nome}}</label>
                                </div>
                                @endforeach
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <h5 class="mb-3">Membros Externos</h5>
                        <div class="form-group" id="professores_externos">
                 <br>
                 <label for="professores" class="form-label">Professores externos:</label>
                 <a href="#" class="btn btn-outline-primary btn-sm py-0" data-bs-toggle="modal" data-bs-target="#createProfessorExterno">
                                    <i class="fas fa-plus fa-xs"></i> Novo
                                </a>
                 @foreach ($professores_externos as $professor_externo)
                                <div class="form-check">
                                    {{-- Adiciona o atributo 'checked' se o professor já estiver na banca --}}
                                    <input type="checkbox" class="form-check-input" name="professores_externos[]" id="professor_externo_{{$professor_externo->id}}" value="{{$professor_externo->id}}"
                                        {{ $banca->professoresExternos->contains($professor_externo->id) ? 'checked' : '' }}>
                                    <label for="professor_externo_{{$professor_externo->id}}" class="form-check-label">{{$professor_externo->nome}} - {{$professor_externo->filiacao}}</label>
                                </div>
                                @endforeach
             </div>
                    </div>
                </div>
                
                <div class="mt-4 d-flex justify-content-end">
                    <a href="{{ route('banca.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('modal.createProfessor')
@include('modal.createProfessorExterno')

@stop

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
     $(document).ready(function() {
         $('#presidente').change(function() {
             var selectedPresidenteId = $(this).find(':selected').data('professor-id');

             $('input[name="professores_internos[]"]').prop('checked', false);
             $('input[name="professores_internos[]"]').prop('disabled', false);

             // Marque o checkbox correspondente ao presidente selecionado
             $('#professor_' + selectedPresidenteId).prop('checked', true);
             $('#professor_' + selectedPresidenteId).prop('disabled', true);
         });
     });
 </script>
