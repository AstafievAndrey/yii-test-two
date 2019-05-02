<?php
$this->title = 'Создать бизнес страницу';
$src = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNmEzYWM4ZDUzMCB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE2YTNhYzhkNTMwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQ0LjA1NDY4NzUiIHk9Ijc0LjUiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=';
?>
<div style="max-width: 800px; margin: 0px auto;">
    <div class="row shadow p-b-10">
        <form name="form" class="col-sm-12" novalidate>
            <h1 class="align-center"><?=$this->title?></h1>
            <div class="row">
                <div class="col-sm-6">
                    <select name="city[]" multiple id="" required class="form-control input-sm">
                        <?php foreach($cities as $city) {
                            echo '<option value="' . $city->id . '">' . $city->name . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <span class="label-create">Выберите город из списка.</span>
                </div>
            </div>
            <div class="row m-t-8">
                <div class="col-sm-6">
                    <select name="city[]" multiple id="" required class="form-control input-sm">
                        <?php foreach($categories as $category) {
                            echo '<option value="' . $category->id . '">' . $category->name . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <span class="label-create">Выберите категорию из списка.</span>
                </div>
            </div>
            <div class="row m-t-8">
                <div class="col-sm-6" id="sites">
                    <div class="input-group">
                        <input name="sites[]" type="text" class="form-control"
                               placeholder="Укажите сайт"
                               required>
                        <span class="input-group-btn">
                            <button onclick="addForm.addSite()" class="btn btn-default" type="button">+</button>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <span class="label-create">Добавьте свой сайт ссылки на социальные сети.</span>
                </div>
            </div>
            <div class="row m-t-8">
                <div class="col-sm-6">
                    <input required type="text" class="form-control" placeholder="Введите заголовок страницы">
                </div>
                <div class="col-sm-6">
                    <span class="label-create">Заголовок страницы. Пример: "Оптовый магазин 'Гамма'".</span>
                </div>
            </div>
            <div class="row m-t-8">
                <div class="col-sm-12">
                    <textarea required
                              name="description"
                              type="text"
                              placeholder="Описание страницы"
                              class="form-control textarea"></textarea>
                </div>
            </div>
            <div class="row m-t-8">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-default"
                            onclick="addForm.openFileSelect()">
                        <div class="hidden">
                            <input accept="image/*"
                                   id="file"
                                   multiple
                                   type="file"
                                   name="image[]"
                                   required
                                   onchange="addForm.handleChangeFile(this)">
                        </div>
                        Прикрепить изображение
                    </button>
                </div>
            </div>
            <div id="img-container" class="row m-t-8"></div>
            <div class="row m-t-8">
                <div class="col-sm-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input type="checkbox" required>
                        </span>
                        <button class="btn btn-default"
                                type="button"
                                onclick="addForm.validateForm()">Добавить</button>
                        Согласен с пользовательским соглашением
                    </div>
                </div>
            </div>
        </form>
        <div id="alerts" class="col-sm-12 m-t-8">
            <div id="errorFiles" class="alert alert-danger hidden"></div>
        </div>
    </div>
</div>