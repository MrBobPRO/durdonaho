// initialize plugins and components
$(document).ready(function () {
    $('.selectize-singular').selectize({
        //options
    });

    $('.selectize-singular-linked').selectize({
        onChange(value) {
            window.location = value;
        }
    });

    $('.selectize-multiple').selectize({
        //options
    });
});


// Add headers into Ajax Request
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


// Enable Bootstraps 5 tooltips everywhere
let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})


// Initialize Simditor WYSIWYG
Simditor.locale = 'ru-RU';

document.querySelectorAll('.simditor-wysiwyg').forEach((item) => {
    Simditor({
        textarea: item,
        toolbarFloatOffset: '60px',
        imageButton: 'upload',
        toolbar: ['title', 'bold', 'italic', 'underline', 'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'hr', '|', 'indent', 'outdent', 'alignment'] //image removed
        // upload: {
        //    url: '/upload/simditor_photo',   //image upload url by server
        //    params: {
        //       folder: 'news' //used in store folder path
        //    },
        //    fileKey: 'simditor_photo', //name of input
        //    connectionCount: 10,
        //    leaveConfirm: 'Пожалуйста дождитесь окончания загрузки изображений на сервер! Вы уверены что хотите закрыть страницу?'
        // },
        // defaultImage: '/img/news/simditor/default/default.png', //default image thumb while uploading
        // cleanPaste: true, //clear all styles while copy pasting,
    });
});


// toggle Aside Visibility
document.querySelector('#aside-toggler-button').addEventListener('click', (evt) => {
    document.body.classList.toggle('body_with_hidden_aside');

    evt.target.innerHTML = evt.target.innerHTML == 'chevron_left' ? 'menu' : 'chevron_left';
});


// Toggle Table Forms checkboxes on select all button click
document.querySelector('#header-select-all-button').addEventListener('click', (evt) => {
    let tableForm = document.querySelector('#table-form')
    let checkboxes = tableForm.querySelectorAll('input[type="checkbox"]');

    // check if all checkboxes selected
    let checkedAll = true;

    for (chb of checkboxes) {
        if (!chb.checked) {
            checkedAll = false;
            break;
        }
    }

    // toggle checkbox statements
    for (chb of checkboxes) {
        chb.checked = !checkedAll;
    }
});


// MODALS FOR DELETING ITEMS
// One modal is used for deleting any item in Table Form
function showSingleDestroyModal(id) {
    // Change the value of input and show Single Item Destroy Modal
    let modal = new bootstrap.Modal(document.getElementById('destroy-single-modal'));
    document.getElementById('destroy-single-modal-input').value = id;

    modal.show();
}

// Submit Table Form on Multiple destroy button click
function submitTableForm() {
    document.getElementById('table-form').submit();
}


// Show image from local on image input change
document.querySelectorAll('[data-action="show-image-from-local"]').forEach(input => {
    input.addEventListener("change", event => {
        var file = input.files[0];
        var imageType = /image.*/;

        if (file.type.match(imageType)) {
            var reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById(input.dataset.target).src = reader.result;
            }

            reader.readAsDataURL(file);	
        } else {
            input.value = '';
            alert('Формат файла не поддерживается!');
        }
    });
});