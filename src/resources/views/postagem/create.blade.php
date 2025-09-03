@extends('layouts.main')

@section('title', 'Criar Postagem')

@section('content')


@include('layouts.flash-message')

<div class="custom-container">
    <div>
        <div>
            <i class="fas fa-pen-to-square fa-2x"></i>
            <h3 class="smaller-font form-label">Criar Postagem</h3>
        </div>
    </div>
</div>
<div class="container form-container-main">
    <form method="post" action="{{ route('postagem.store') }}" enctype="multipart/form-data" id="postagemForm">
    @csrf

        <div class="form-section-paper">
            <div class="form-group">
                <label for="titulo" class="form-label">Título*:</label>
                <input value="{{ old('titulo', isset($postagem) ? $postagem['titulo'] : '') }}" type="text" name="titulo"
                    id="titulo" class="form-control" placeholder="Título da postagem" required>
            </div>

            <div class="form-group">
                <label for="texto" class="form-label">Texto*:</label>
                <textarea name="texto" id="texto" class="form-control" placeholder="Texto da postagem">{{ old('texto', isset($postagem) ? $postagem['texto'] : '') }}</textarea>
            </div>

            <div class="form-group">
                <label for="tipo_postagem" class="form-label">Tipo*:</label>
                <select name="tipo_postagem_id" id="tipo_postagem_id" class="form-control" required>
                    @foreach ($tipo_postagens as $key => $value)
                        <option value="{{ $key }}" {{ $key == old('tipo_postagem_id', $id ?? '') ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-section-paper">
            <h5>Capa da Postagem</h5>
            <p class="text-muted">A imagem de capa deve ter a proporção de 2700x660 pixels.</p>

            <div id="upload-container">
                <label for="main_image" class="custom-file-button">Procurar Capa</label>
                <input type="file" name="main_image" id="main_image" class="hidden-file-input" accept="image/*">
            </div>
        </div>   

        <div class="form-section-paper">
            <h5>Imagens Adicionais</h5>
            <label for="imagens" class="custom-file-button">Procurar Imagens</label>
            <input type="file" name="imagens[]" id="imagens" class="hidden-file-input" accept="image/*" multiple>
            <div id="imagens-preview-container" class="preview-container"></div>
        </div>

        <div class="form-section-paper">
            <h5>Anexar Arquivos</h5>
            <p class="text-muted">Tamanho máximo permitido por arquivo: 60MB.</p>
            <label for="arquivos" class="custom-file-button">Procurar Arquivos</label>
            <input type="file" name="arquivos[]" id="arquivos" class="hidden-file-input" multiple>
            <div id="arquivos-preview-container" class="preview-container"></div>
        </div>

        <button type="submit" class="btn custom-button btn-default">Cadastrar</button>
        <a href="{{ route('postagem.index') }}" class="btn custom-button custom-button-castastrar-tcc btn-default">Cancelar</a>
    </form>
</div>

<div id="image-viewer-modal" class="image-modal">
    <img id="modal-image-content" class="image-modal-content">
    <span class="close-modal">&times;</span>
</div>

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
    cursor: pointer;
}

.image-modal img {
    cursor: default;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('image-viewer-modal');
    const closeBtn = modal.querySelector('.close-modal');
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            modal.style.display = 'none';
        }
    });
});
</script>

<!-- Modal de Recorte -->
<div class="modal" id="cropper-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajustar Imagem de Capa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <p class="crop-instructions mb-0">
                        Use as alças para ajustar o recorte. Arraste a imagem para reposicionar e use o scroll do mouse para dar zoom.
                    </p>
                </div>
                <div id="cropper-container" class="crop-container bg-light">
                    <img id="cropper-image" src="" style="max-width: 100%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-confirmar" id="crop-button">Confirmar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let cropper = null;
    let originalFile = null;
    
    window.removeMainImage = function() {
        const mainImageInput = document.getElementById('main_image');
        const container = document.getElementById('upload-container');

        if (mainImageInput) {
            mainImageInput.value = '';
        }

        const croppedField = document.getElementById('cropped_image_data');
        if (croppedField) {
            croppedField.remove();
        }

        let removeField = document.getElementById('remove_capa');
        if (!removeField) {
            removeField = document.createElement('input');
            removeField.type = 'hidden';
            removeField.name = 'remove_capa';
            removeField.id = 'remove_capa';
            removeField.value = '1';
            document.getElementById('postagemForm').appendChild(removeField);
        }

        if (container) {
            container.innerHTML = '<label for="main_image" class="custom-file-button">Procurar Capa</label>';
            mainImageInput.addEventListener('change', handleMainImageChange);
        }
    };
let dataTransferImages;
let dataTransferFiles;

document.addEventListener('DOMContentLoaded', function () {
    dataTransferImages = new DataTransfer();
    dataTransferFiles = new DataTransfer();
    
    let mainImageInput = document.getElementById('main_image');
    const imagesInput = document.getElementById('imagens');
    const filesInput = document.getElementById('arquivos');
    const mainImagePreviewContainer = document.getElementById('upload-container');
    const imagesPreviewContainer = document.getElementById('imagens-preview-container');
    const filesPreviewContainer = document.getElementById('arquivos-preview-container');
    const imageViewerModal = document.getElementById('image-viewer-modal');
    const modalImageContent = document.getElementById('modal-image-content');
    const cropperModalElement = document.getElementById('cropper-modal');
    const cropperContainer = document.getElementById('cropper-container');
    const cropperImage = document.getElementById('cropper-image');
    const cropButton = document.getElementById('crop-button');

        

        function handleMainImageChange(event) {
            const file = event.target.files[0];
            if (!file) return;

            originalFile = file;
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (cropperContainer) {
                    cropperContainer.innerHTML = '<img id="cropper-image" src="' + e.target.result + '">';
                    const bsModal = new bootstrap.Modal(cropperModalElement);
                    bsModal.show();
                }
            };
            
            reader.readAsDataURL(file);
        }


        mainImageInput.removeEventListener('change', handleMainImageChange);
        

        mainImageInput.addEventListener('change', handleMainImageChange);


        cropperModalElement.addEventListener('shown.bs.modal', function () {
            const image = document.getElementById('cropper-image');
            if (!image) return;

            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            cropper = new Cropper(image, {
                aspectRatio: 2700 / 660,
                viewMode: 2,
                dragMode: 'move',
                background: true,
                responsive: true,
                modal: true,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                wheelZoomRatio: 0.1,
                zoomable: true,
                zoomOnTouch: true,
                zoomOnWheel: true,
                autoCropArea: 0.85
            });
        });


        cropperModalElement.addEventListener('hidden.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            const container = document.getElementById('cropper-container');
            if (container) {
                container.innerHTML = '';
            }

    
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            document.documentElement.style.overflow = '';
            
    
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
        });


        cropButton.addEventListener('click', function() {
            if (!cropper) {
                console.error('Cropper not initialized');
                return;
            }

            try {
                const canvas = cropper.getCroppedCanvas({
                    width: 2700,
                    height: 660,
                    imageSmoothingQuality: 'high'
                });

                if (!canvas) {
                    throw new Error('Failed to create canvas');
                }

        
                const base64Image = canvas.toDataURL('image/jpeg', 0.8);
                
        
                let hiddenInput = document.getElementById('cropped_image_data');
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.id = 'cropped_image_data';
                    hiddenInput.name = 'cropped_image_data';
                   document.getElementById('postagemForm').appendChild(hiddenInput);
                }
                hiddenInput.value = base64Image;

        
                const container = document.getElementById('upload-container');
                if (container) {
            
                    const label = document.createElement('label');
                    label.htmlFor = 'main_image';
                    label.className = 'custom-file-button';
                    label.textContent = 'Alterar Capa';

                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'preview-item mt-3';

                    const img = document.createElement('img');
                    img.src = base64Image;
                    img.alt = 'Preview';
                    img.style.cursor = 'pointer';
                    img.onclick = function() {
                        const modal = document.getElementById('image-viewer-modal');
                        const modalImg = document.getElementById('modal-image-content');
                        if (modal && modalImg) {
                            modalImg.src = this.src;
                            modal.style.display = 'flex';
                        }
                    };

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'remove-preview-btn';
                    removeBtn.innerHTML = '&times;';
                    removeBtn.onclick = function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        removeMainImage();
                    };

            
                    container.innerHTML = '';
                    container.appendChild(label);
                    
                    previewDiv.appendChild(img);
                    previewDiv.appendChild(removeBtn);
                    container.appendChild(previewDiv);
                }

        
                const modal = bootstrap.Modal.getInstance(cropperModalElement);
                if (modal) {
                    modal.hide();
                }

        
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }

        
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.documentElement.style.overflow = '';
                
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }

            } catch (error) {
                console.error('Erro ao recortar imagem:', error);
                alert('Ocorreu um erro ao recortar a imagem. Por favor, tente novamente.');
                
        
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }

                const modal = bootstrap.Modal.getInstance(cropperModalElement);
                if (modal) {
                    modal.hide();
                }

                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.documentElement.style.overflow = '';
                
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            }
        });



        imagesInput.addEventListener('change', function(event) {
            handleFileUpload(event.target.files, imagesPreviewContainer, dataTransferImages, imagesInput, true);
        });
        
        filesInput.addEventListener('change', function(event) {
            handleFileUpload(event.target.files, filesPreviewContainer, dataTransferFiles, filesInput, false);
        });


        
        function handleFileUpload(newFiles, previewContainer, dataTransfer, inputElement, isImage) {
            Array.from(newFiles).forEach(file => {
                dataTransfer.items.add(file);
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = createPreviewItem(e.target.result, file.name, inputElement, isImage);
                    previewContainer.appendChild(previewItem);
                };
                
                if(isImage) {
                    reader.readAsDataURL(file);
                } else {
                    const previewItem = createPreviewItem(null, file.name, inputElement, isImage);
                    previewContainer.appendChild(previewItem);
                }
            });
            inputElement.files = dataTransfer.files;
        }

        function createPreviewItem(src, fileName, inputElement, isImage) {
            const previewItem = document.createElement('div');
            previewItem.className = isImage ? 'preview-item' : 'file-preview-item';
            
            if (isImage) {
                const img = document.createElement('img');
                img.src = src;
                img.alt = 'Preview';
                img.onclick = () => {
                    modalImageContent.src = src;
                    imageViewerModal.style.display = 'flex';
                };
                previewItem.appendChild(img);
            } else {
        
                const fileLink = document.createElement('a');
                fileLink.href = URL.createObjectURL(Array.from(inputElement.files).find(file => file.name === fileName));
                fileLink.target = '_blank'
                fileLink.style.textDecoration = 'none'
                fileLink.style.color = 'inherit'
                fileLink.style.display = 'flex';
                fileLink.style.alignItems = 'center';
                fileLink.style.gap = '10px';
                
                const icon = document.createElement('i');
                icon.className = 'fas fa-file-alt file-icon';
                const info = document.createElement('span');
                info.className = 'file-info';
                info.textContent = fileName;
                
                fileLink.appendChild(icon);
                fileLink.appendChild(info);
                previewItem.appendChild(fileLink);
            }
            
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-preview-btn';
            removeBtn.innerHTML = '&times;';
            removeBtn.onclick = (e) => {
                e.stopPropagation();
                removeFileFromFileList(fileName, inputElement);
                previewItem.remove();
            };

            previewItem.appendChild(removeBtn);
            return previewItem;
        }

        function removeFileFromFileList(fileName, inputElement) {
            const dt = (inputElement.id === 'imagens') ? dataTransferImages : dataTransferFiles;
            const newDt = new DataTransfer();
            Array.from(dt.files).forEach(file => {
                if (file.name !== fileName) {
                    newDt.items.add(file);
                }
            });
            dt.items.clear();
            Array.from(newDt.files).forEach(file => dt.items.add(file));
            inputElement.files = dt.files;
        }
    });
</script>

<!-- Fallback Summernote CDN in case Vite assets don't load -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-lite.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-lite.min.css" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if Summernote is available and textarea exists
    if (typeof $.fn.summernote !== 'undefined' && $('#texto').length) {
        // Initialize Summernote
        $('#texto').summernote({
            lang: 'pt-BR',
            placeholder: 'Digite o conteúdo da sua postagem aqui...',
            tabsize: 2,
            height: 300,
            disableDragAndDrop: true,
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Lucida Grande', 'Tahoma', 'Times New Roman', 'Verdana'],
            fontNamesIgnoreCheck: ['Arial Black', 'Comic Sans MS', 'Lucida Grande', 'Times New Roman'],
            toolbar: [
                ['style', ['style']],
                ['text', ['bold', 'italic', 'underline', 'strikethrough']],
                ['font', ['superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ]
        });
    } else {
        console.log('Summernote not loaded or textarea not found');
    }
});
</script>
@endpush
@stop
