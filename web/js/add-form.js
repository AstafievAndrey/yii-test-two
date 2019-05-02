const imgSrc = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNmEzYWM4ZDUzMCB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE2YTNhYzhkNTMwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQ0LjA1NDY4NzUiIHk9Ijc0LjUiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=';
const addForm = new AddForm();

function AddForm() {
    this.windowUrl = window.URL || window.webkitURL;
    this.siteCount = 1;
}

// удалим поле добавить сайт
AddForm.prototype.removeSite = function (element) {
    element.parentNode.parentNode.remove();
    this.siteCount -= 1;
}

// добавим поле добавить сайт
AddForm.prototype.addSite = function () {
    let sites = '<div class="input-group m-t-8">' +
                    '<input name="sites[]" type="text" class="form-control" required>' +
                    '<span class="input-group-btn">' +
                        '<button onclick="addForm.removeSite(this)" class="btn btn-default" type="button">-</button>' +
                    '</span>' +
                '</div>';
    if(this.siteCount !== 5) {
        document.getElementById('sites').innerHTML += sites;
        this.siteCount += 1;
    }
}

// откроем модальное окно выбора файла
AddForm.prototype.openFileSelect = function () {
    document.getElementById('file').click();
};

// валидация на добавленные файлы
AddForm.prototype.handleChangeFile = function (elem) {
    let error = document.getElementById('errorFiles');
    let countError = 0;

    let showError = (text) => {
        error.innerHTML += `<div>${text}</div>`;
        countError += 1;
    }

    const setPreview = (files) => {
        let images = document.getElementsByClassName('add-image');
        Array.prototype.forEach.call(files,  (file, index) => {
            images[index].src = this.windowUrl.createObjectURL(file);
        });
    }

    const resetPreview = function () {
        let images = document.getElementsByClassName('add-image');
        Array.prototype.forEach.call(images, function (image) {
            image.src = imgSrc;
        });
    }

    error.innerHTML = '';
    if (elem.files.length > 6) {
        showError('Выберите мешьше шести файлов.')
    }

    Array.prototype.forEach.call(elem.files, function (file) {
        if (file.size > 250000) {
            showError(`Файл ${file.name} превышает 250 кБ`);
        }
    });

    if (countError === 0) {
        document.getElementById('errorFiles').classList.add('hidden');
        setPreview(elem.files);
    } else {
        error.classList.remove('hidden');
        resetPreview();
        document.getElementById('file').value = "";
    }
}

AddForm.prototype.validateForm = function () {
    let inp = form.querySelectorAll('input');
    let select = form.querySelectorAll('select');
    let textarea = form.querySelectorAll('textarea');
    let validate = (elements) => {
        Array.prototype.forEach.call(elements, (elem) => {
            if(!elem.checkValidity()) {
                elem.classList.add('border-color-red');
            } else {
                elem.classList.remove('border-color-red');
            }
        });
    }
    validate(inp);
    validate(select);
    validate(textarea);
}

