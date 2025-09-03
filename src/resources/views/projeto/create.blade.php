@extends('layouts.main')

@section('title', 'Criar Projeto')

@section('content')
    <div class="custom-container">
        <div>
            <div>
                <i class="fas fa-envelopes-bulk fa-2x"></i>
                <h3 class="smaller-font">Cadastro de Projeto</h3>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="card-body">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <form method="post" action="{{ route('projeto.store') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- INFORMAÇÕES GERAIS --}}
                            <h5 class="card-title mb-3">Informações Gerais</h5>
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título*:</label>
                                <textarea name="titulo" id="titulo" placeholder="Título do projeto" required
                                    class="form-control @error('titulo') is-invalid @enderror">{{ old('titulo') }}</textarea>
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="descricao" class="form-label">Descrição*:</label>
                                <textarea name="descricao" id="descricao" placeholder="Descrição do projeto" required
                                    class="form-control @error('descricao') is-invalid @enderror" rows="4">{{ old('descricao') }}</textarea>
                                @error('descricao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            {{-- DATAS E CRONOGRAMA --}}
                            <h5 class="card-title mb-3">Cronograma</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="data_inicio" class="form-label">Data de Início*:</label>
                                    <input type="date" name="data_inicio" id="data_inicio" value="{{ old('data_inicio') }}"
                                        class="form-control @error('data_inicio') is-invalid @enderror" required>
                                    @error('data_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="data_termino" class="form-label">Data de Término:</label>
                                    <input type="date" name="data_termino" id="data_termino" value="{{ old('data_termino') }}"
                                        class="form-control @error('data_termino') is-invalid @enderror">
                                    @error('data_termino')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- DETALHES ADICIONAIS --}}
                            <h5 class="card-title mb-3">Detalhes Adicionais</h5>
                            <div class="mb-3">
                                <label for="resultados" class="form-label">Resultados:</label>
                                <input type="text" name="resultados" id="resultados" value="{{ old('resultados') }}"
                                    class="form-control @error('resultados') is-invalid @enderror" placeholder="Resultados do projeto">
                                @error('resultados')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="palavras_chave" class="form-label">Palavras-Chave*:</label>
                                <input type="text" name="palavras_chave" id="palavras_chave" value="{{ old('palavras_chave') }}"
                                    class="form-control @error('palavras_chave') is-invalid @enderror" placeholder="Palavras Chave">
                                @error('palavras_chave')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="fomento" class="form-label">Fomento:</label>
                                <input type="text" name="fomento" id="fomento" value="{{ old('fomento') }}"
                                    class="form-control @error('fomento') is-invalid @enderror" placeholder="Fomento">
                                @error('fomento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="link" class="form-label">Link:</label>
                                <input type="url" name="link" id="link" value="{{ old('link') }}"
                                    class="form-control @error('link') is-invalid @enderror" placeholder="Link">
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            {{-- RESPONSÁVEIS E COLABORADORES --}}
                            <h5 class="card-title mb-3">Responsáveis e Colaboradores</h5>
                            <div class="mb-3">
                                <label for="professor_id" class="form-label">Professor Responsável*:</label>
                                <select name="professor_id" id="professor_id"
                                    class="form-select @error('professor_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Selecione um professor</option>
                                </select>
                                @error('professor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="professores" class="form-label">Professores Colaboradores:</label>
                                <select class="form-select" name="professores[]" id="professores" multiple>
                                    <option value="" disabled>Selecione os colaboradores</option>
                                </select>
                                <small class="form-text text-muted">Use Ctrl+clique para selecionar múltiplos professores</small>
                            </div>
                            <button type="button" class="btn custom-button fw-bold mb-3" data-bs-toggle="modal" data-bs-target="#createProfessor" title="Cadastrar professor">
                                Cadastrar professor
                            </button>

                            <div class="mb-3">
                                <label for="professores_externos" class="form-label">Professores Externos:</label>
                                <select class="form-select" name="professores_externos[]" id="professores_externos" multiple>
                                    <option value="" disabled>Selecione os professores externos participantes</option>
                                </select>
                                <small class="form-text text-muted">Use Ctrl+clique para selecionar múltiplos professores</small>
                            </div>
                            <button type="button" class="btn custom-button fw-bold mb-3" data-bs-toggle="modal" data-bs-target="#createProfessorExterno" title="Cadastrar professor externo">
                                Cadastrar professor Externo
                            </button>

                            <div class="mb-3">
                                <label for="alunos_bolsistas" class="form-label">Alunos Bolsistas:</label>
                                <select class="form-select" name="alunos_bolsistas[]" id="alunos_bolsistas" multiple>
                                    <option value="" disabled>Selecione um aluno para o projeto</option>
                                </select>
                                <small class="form-text text-muted">Use Ctrl+clique para selecionar múltiplos alunos</small>
                            </div>

                            <div class="mb-4">
                                <label for="alunos_voluntarios" class="form-label">Alunos Voluntários:</label>
                                <select class="form-select" name="alunos_voluntarios[]" id="alunos_voluntarios" multiple>
                                    <option value="" disabled>Selecione um aluno para o projeto</option>
                                </select>
                                <small class="form-text text-muted">Use Ctrl+clique para selecionar múltiplos alunos</small>
                            </div>
                            <button type="button" class="btn custom-button fw-bold mb-3" data-bs-toggle="modal" data-bs-target="#createAluno" title="Cadastrar aluno">
                                Cadastrar aluno
                            </button>

                            <hr class="my-4">
        
                            {{-- ANEXOS E IMAGENS --}}
                            <h5 class="card-title mb-3">Anexos e Imagens</h5>
                            
                            <div class="mb-4">
                                <h6 class="text-muted mb-3">Imagens do Projeto</h6>
                                <div id="all-images-container" class="preview-container">
                                    {{-- IMAGENS SERÃO ADICIONADAS AQUI VIA JAVASCRIPT --}}
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Adicionar Imagens:</label>
                                <div class="upload-section">
                                    <label for="imagens" class="custom-file-button">
                                        <i class="fas fa-images me-2"></i>Procurar Imagens
                                    </label>
                                    <input type="file" name="imagens[]" id="imagens" class="hidden-file-input" accept="image/*" multiple>
                                    @error('imagens.*')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="text-center">
                                <button type="submit" class="btn custom-button btn-default me-3">
                                    <i class="fas fa-save me-2"></i>Cadastrar Projeto
                                </button>
                                <a href="{{ route('projeto.index') }}" class="btn custom-button custom-button-castastrar-tcc btn-default">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL E SCRIPTS PARA PREVIEW DE IMAGENS --}}
    <div id="image-viewer-modal" class="image-modal">
        <img id="modal-image-content" class="image-modal-content">
        <span class="close-modal">&times;</span>
    </div>

    @include('modal.createProfessor')
    @include('modal.createAluno')
    @include('modal.createProfessorExterno')

    <style>
        .close-modal {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .image-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .image-modal-content {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }

        .image-modal img {
            cursor: default;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            font-size: 16px;
            line-height: 1;
        }

        .remove-btn:hover {
            background: rgba(255, 0, 0, 1);
        }

        /* Estilos adicionais para consistência */
        .upload-section {
            text-align: left;
            padding: 0;
        }

        /* Estilos para Select2 */
        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            height: 38px !important;
            line-height: 36px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            font-size: 1rem !important;
        }

        .select2-container--default .select2-selection--multiple {
            min-height: 38px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            font-size: 1rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #495057 !important;
            padding-left: 12px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            padding: 6px 12px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
            right: 12px !important;
        }

        .select2-dropdown {
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
        }

        .form-text {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>

    <script type="text/javascript">
        // Script para Select2 do professor responsável (seleção única)
        $('#professor_id').select2({
            placeholder: 'Selecione um professor',
            language: {
                noResults: function() {
                    return "Resultados não encontrados";
                },
                inputTooShort: function() {
                    return "Digite 1 ou mais caracteres";
                }
            },
            minimumInputLength: 1,
            ajax: {
                url: '/projeto/busca-professor',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nome,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        // Script para Select2 dos colaboradores (seleção múltipla)
        $('#professores').select2({
            placeholder: 'Selecione os colaboradores',
            language: {
                noResults: function() {
                    return "Resultados não encontrados";
                },
                inputTooShort: function() {
                    return "Digite 1 ou mais caracteres";
                }
            },
            minimumInputLength: 1,
            ajax: {
                url: '/projeto/busca-professor',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nome,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        // Script para Select2 dos professores externos (seleção múltipla)
        $('#professores_externos').select2({
            placeholder: 'Selecione os professores externos participantes',
            language: {
                noResults: function() {
                    return "Resultados não encontrados";
                },
                inputTooShort: function() {
                    return "Digite 1 ou mais caracteres";
                }
            },
            minimumInputLength: 1,
            ajax: {
                url: '/projeto/busca-professor-externo',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nome + ' - ' + item.filiacao,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        // Script para Select2 dos alunos bolsistas (seleção múltipla)
        $('#alunos_bolsistas').select2({
            placeholder: 'Selecione um aluno para o projeto',
            language: {
                noResults: function() {
                    return "Resultados não encontrados";
                },
                inputTooShort: function() {
                    return "Digite 1 ou mais caracteres";
                }
            },
            minimumInputLength: 1,
            ajax: {
                url: '/projeto/busca-aluno',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nome,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        // Script para Select2 dos alunos voluntários (seleção múltipla)
        $('#alunos_voluntarios').select2({
            placeholder: 'Selecione um aluno para o projeto',
            language: {
                noResults: function() {
                    return "Resultados não encontrados";
                },
                inputTooShort: function() {
                    return "Digite 1 ou mais caracteres";
                }
            },
            minimumInputLength: 1,
            ajax: {
                url: '/projeto/busca-aluno',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nome,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        // Script para preview de imagens (baseado na página de postagem)
        let dataTransferImages;

        document.addEventListener('DOMContentLoaded', function () {
            dataTransferImages = new DataTransfer();
            
            const imagesInput = document.getElementById('imagens');
            const allImagesContainer = document.getElementById('all-images-container');
            const imageViewerModal = document.getElementById('image-viewer-modal');
            const modalImageContent = document.getElementById('modal-image-content');

            // Função para preview de imagens
            if (imagesInput) {
                imagesInput.addEventListener('change', function (e) {
                    const files = Array.from(e.target.files);
                    
                    files.forEach(file => {
                        if (file.type.startsWith('image/')) {
                            dataTransferImages.items.add(file);
                            
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const previewItem = document.createElement('div');
                                previewItem.className = 'preview-item';
                                previewItem.innerHTML = `
                                    <img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">
                                    <button type="button" class="remove-btn" onclick="removeImagePreview(this, '${file.name}')">&times;</button>
                                `;
                                
                                previewItem.querySelector('img').addEventListener('click', function() {
                                    modalImageContent.src = e.target.result;
                                    imageViewerModal.style.display = 'flex';
                                });
                                
                                allImagesContainer.appendChild(previewItem);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                    
                    imagesInput.files = dataTransferImages.files;
                });
            }

            // Fechar modal ao clicar fora da imagem
            if (imageViewerModal) {
                imageViewerModal.addEventListener('click', function(e) {
                    if (e.target === imageViewerModal || e.target.classList.contains('close-modal')) {
                        imageViewerModal.style.display = 'none';
                    }
                });
            }
        });

        // Função para remover preview de imagem
        window.removeImagePreview = function(button, fileName) {
            const previewItem = button.parentElement;
            previewItem.remove();
            
            // Remover arquivo do DataTransfer
            const newFiles = Array.from(dataTransferImages.files).filter(file => file.name !== fileName);
            dataTransferImages = new DataTransfer();
            newFiles.forEach(file => dataTransferImages.items.add(file));
            document.getElementById('imagens').files = dataTransferImages.files;
        };

        // Correção global para problemas de scroll com modais
        $(document).ready(function() {
            $('.modal').on('hidden.bs.modal', function () {
                // Remove classes e estilos que podem causar problemas de scroll
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                $('body').css('padding-right', '');
                $('body').css('overflow', '');
            });
        });
    </script>

    @include('modal.createProfessor')
    @include('modal.createAluno')
    @include('modal.createProfessorExterno')

@endsection
