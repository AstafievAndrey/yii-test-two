<?php
$this->title = 'Создать бизнес страницу';
?>
<div class="row shadow p-b-10">
    <div class="col-sm-12">
        <h1 class="align-center"><?=$this->title?></h1>
        <div class="row">
            <div class="col-sm-6">
                <select name="city[]" multiple id="" class="form-control input-sm">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <div class="col-sm-6">
                <span>выберите город из списка</span>
            </div>
        </div>
        <div class="row m-t-8">
            <div class="col-sm-6">
                <select name="city[]" multiple id="" class="form-control input-sm">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <div class="col-sm-6">
                <span>выберите категорию из списка</span>
            </div>
        </div>
    </div>
</div>