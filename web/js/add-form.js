const addForm = new AddForm();

function AddForm() {
    this.windowUrl = window.URL || window.webkitURL;
    this.siteCount = 1;
    this.fileList = [];
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
    let fileList = [];
    if(this.siteCount !== 5) {
        document.getElementById('sites').innerHTML += sites;
        this.siteCount += 1;
    }
}

// откроем модальное окно выбора файла
AddForm.prototype.openFileSelect = function () {
    document.getElementById('file').click();
};

AddForm.prototype.removeFileList = function(elem, fileListIndex) {
    this.fileList.splice(fileListIndex, 1);
    elem.parentNode.remove();
}

// добавим изображение в блок
AddForm.prototype.addImage = function(src, fileListIndex) {
    let div = document.createElement('div');
    let img = document.createElement('img');
    div.classList.add('col-sm-2', 'col-xs-6');
    div.innerHTML = `<span onclick="addForm.removeFileList(this, ${fileListIndex})" 
                        class="glyphicon glyphicon-remove img-remove" aria-hidden="true"></span>`;
    img.classList.add('img-thumbnail', 'add-image');
    img.src = src;
    div.appendChild(img);
    document.getElementById('img-container').appendChild(div);
}

// валидация на добавляемые файлы
AddForm.prototype.handleChangeFile = function (elem) {
    let newFileList = [ ...this.fileList, ...elem.files].filter((current, index, arr) => {
        return arr.map(itemArr => itemArr['name']).indexOf(current['name']) === index
            && arr.map(itemArr => itemArr['size']).indexOf(current['size']) === index;
    });
    let error = document.getElementById('errorFiles');
    let countError = 0;
    let removeIndex = [];

    const showError = (text) => {
        error.innerHTML += `<div>${text}</div>`;
        countError += 1;
    }
    const setPreview = (files) => {
        Array.prototype.forEach.call(files,  (file) => {
            this.addImage(this.windowUrl.createObjectURL(file));
        });
    }

    error.innerHTML = '';
    Array.prototype.forEach.call(newFileList, function (file, index) {
        if (file.size > 250000) {
            showError(`Файл ${file.name} превышает 250 кБ`);
            removeIndex.unshift(index);
        }
    });
    removeIndex.forEach((value) => {
        newFileList.splice(value, 1)
    });

    if (newFileList.length > 6) {
        showError('Выберите меньше шести файлов.')
    }

    this.fileList = newFileList;
    document.getElementById('img-container').innerHTML = '';
    setPreview(newFileList);

    (countError === 0) ? document.getElementById('errorFiles').classList.add('hidden')
        : error.classList.remove('hidden');
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

