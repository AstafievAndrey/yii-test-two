<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = $item->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-3">
        <div id="carousel" class="carousel slide" data-ride="carousel">
            <?php if(!empty($item->itemsImages)) { ?>
                <ol class="carousel-indicators">
                    <?php
                        for($i = 0; $i < count($item->itemsImages); $i++) {
                            echo '<li data-target="#carousel" data-slide-to="'.$i.'" class="'.($i===0 ? 'active': '').'"></li>';
                        }
                    ?>
                </ol>
            <?php }?>

            <div class="carousel-inner" role="listbox" style="text-align: center;">
                <?php 
                    if (empty($item->itemsImages)) {
                        echo '<img class="img-thumbnail" alt="140x140" style="width: 140px; height: 140px;" 
                        src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNjlkYTc1ZTU3NiB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE2OWRhNzVlNTc2Ij48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQ0LjA1NDY4NzUiIHk9Ijc0LjUiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">';
                    } else {
                        foreach($item->itemsImages as $key=>$value) {
                            echo '<div class="item '.($key===0 ? 'active': '').'">';
                                echo '<img class="img-thumbnail" style="width:100%;" src="data:'
                                    .$value->file->type.';base64,'
                                    .base64_encode($value->image->blob).'"/>';
                                echo '</div>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>

    <div class="col-sm-9">
        <p class="ucfirct" style="margin-top:0px;">
            <span class="h3"><?=$item->name?></span>
        </p>
        <p class="h5">Описание:</p>
        <p>
            <?=nl2br($item->description)?>
        </p>
    </div>
</div>