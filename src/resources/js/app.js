import './bootstrap';


import 'summernote/dist/summernote-lite.js';
import 'summernote/dist/summernote-lite.css';

document.addEventListener('DOMContentLoaded', function() {
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
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
