const addForm = new AddForm();
const FILE_ERROR = 'fileError';
const AGREE_ERROR = 'agreeError';
const STANDARD_ERROR = 'standardError';

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
    let div = document.createElement('div');
    div.classList.add('input-group', 'm-t-8');
    div.innerHTML = '<input name="sites[]" type="text" class="form-control" required>' +
                    '<span class="input-group-btn">' +
                        '<button onclick="addForm.removeSite(this)" class="btn btn-default" type="button">-</button>' +
                    '</span>';
    if(this.siteCount !== 5) {
        document.getElementById('sites').appendChild(div);
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

// добавим определенный тип ошибок
AddForm.prototype.showError = function(text, typeError) {
    let alerts = document.getElementById('alerts-errors');
    alerts.innerHTML += `<div class="alert alert-danger ${typeError}">${text}</div>`;
}

// удалим определенный тип ошибок
AddForm.prototype.removeError = function(...typeError) {
    let alerts = document.getElementById('alerts-errors');
    typeError.forEach((className) => {
        let htmlCollection = alerts.getElementsByClassName(className);
        for(let i = htmlCollection.length; i > 0; i--) {
            alerts.removeChild(htmlCollection[i-1]);
        }
    });

}

// валидация на добавляемые файлы
AddForm.prototype.handleChangeFile = function (elem) {
    const setPreview = (files) => {
        Array.prototype.forEach.call(files,  (file) => {
            this.addImage(this.windowUrl.createObjectURL(file));
        });
    }
    let newFileList = [ ...this.fileList, ...elem.files].filter((current, index, arr) => {
        return arr.map(itemArr => itemArr['name']).indexOf(current['name']) === index
            && arr.map(itemArr => itemArr['size']).indexOf(current['size']) === index;
    });
    let errors = [];
    let removeIndex = [];

    Array.prototype.forEach.call(newFileList, function (file, index) {
        if (file.size > 250000) {
            errors.push(`<div>Файл ${file.name} превышает 250 кБ.</div>`);
            removeIndex.unshift(index);
        }
    });
    removeIndex.forEach((value) => {
        newFileList.splice(value, 1)
    });

    if (newFileList.length > 6) {
        errors.push(`<div>Выберите меньше шести файлов.</div>`);
    }

    this.fileList = newFileList;
    document.getElementById('img-container').innerHTML = '';
    setPreview(newFileList);

    this.removeError(FILE_ERROR);
    if(errors.length !== 0) {
        this.showError(errors.join(''), FILE_ERROR);
    }
}

// подсветим поля красным
AddForm.prototype.fieldIlluminationError = function (...elements) {
    let hasError = false;
    elements.forEach( nodeList =>
        Array.prototype.forEach.call(nodeList, (elem) => {
            if(!elem.checkValidity()) {
                hasError = true;
                elem.classList.add('border-color-red');
            } else {
                elem.classList.remove('border-color-red');
            }
        })
    );
    return hasError;
}

AddForm.prototype.validateForm = function () {
    this.removeError(AGREE_ERROR, FILE_ERROR, STANDARD_ERROR);
    if (this.fieldIlluminationError(
        form.querySelectorAll('input[type="text"]'),
        form.querySelectorAll('select'),
        form.querySelectorAll('textarea')
    )) {
        this.showError('Заполните все поля.', STANDARD_ERROR);
    }

    if(!form.agree.checked) {
        this.showError('Подтвердите пользовательское соглашение.', AGREE_ERROR);
    }

    if(this.fileList.length === 0) {
        this.showError('Добавьте изображения.', FILE_ERROR);
    }

    if(form.checkValidity()) {
        if(this.fileList.length > 6) {
            this.showError('Оставьте только 6 изображений.', FILE_ERROR);
        }
        let data = new FormData(form);
        data.delete('images[]');
        this.fileList.forEach(file => {
            data.append('images[]', file);
        });

        fetch("/login", {
            method: "POST",
            body: data
        });
    }
}

