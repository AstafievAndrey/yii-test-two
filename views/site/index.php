<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */

$this->title = 'Каталог';
?>
<!-- <div class="row">
    <div class="col-sm-12">
        реклама
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        фильтры
    </div>
</div> -->
<div class="row">
    <?php
        foreach($items as $key => $item) {
    ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="thumbnail">
                <?php 
                    if(!empty($item->itemsImages)) {
                        echo '<img class="img-thumbnail" style="height:140px;" src="data:'
                            .$item->itemsImages[0]->image->type.';base64,'
                            .base64_encode($item->itemsImages[0]->image->blob).'"/>';
                    } else {
                        echo '<img class="img-thumbnail" alt="140x140" style="width: 140px; height: 140px;" 
                                src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNjlkYTc1ZTU3NiB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE2OWRhNzVlNTc2Ij48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQ0LjA1NDY4NzUiIHk9Ijc0LjUiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">';
                    }
                ?>
                <div class="caption">
                    <h4 class="head-item"><?=$item->name?></h4>
                    <p>
                    <?= Html::a('Просмотр', ['view/'.$item->translite], 
                            [
                                'class' => 'btn btn-default',
                                'data' => ['method' => 'post'],
                        ])?>  
                        <span>
                            <button onclick="like(<?=$item->id?>, this)" 
                                    <?=($guest ? 'disabled' : '')?>
                                    class="btn btn-success like">
                                <span class="glyphicon glyphicon-thumbs-up" 
                                    aria-hidden="true"></span> 
                                <span class="badge">
                                    <?=$item->getCountRatingType('like');?>
                                </span>
                            </button> 
                            <button onclick="dislike(<?=$item->id?>, this)"  
                                    <?=($guest ? 'disabled' : '')?>
                                    class="btn btn-danger dislike">
                                <span class="glyphicon glyphicon-thumbs-down" 
                                    aria-hidden="true"></span> 
                                <span class="badge">
                                <?=$item->getCountRatingType('dislike');?>
                                </span>
                            </button> 
                        </span>
                    </p>
                </div>
            </div>
        </div>
    <?php
        }
    ?>
</div>

<div class="row">
    <div class="col-sm-12">
        <?php
            echo LinkPager::widget([
                'pagination' => $pages,
            ]);
        ?>
    </div>
</div>

<script>

    function setSpanLikeDislike(element, data) {
        var parent = element.parentNode;
        parent.getElementsByClassName('like')[0]
                .getElementsByClassName('badge')[0].innerText = data.like;
        parent.getElementsByClassName('dislike')[0]
                .getElementsByClassName('badge')[0].innerText = data.dislike;
    }

    function like(item_id, element) {
        fetch(`<?=Url::to(['like/index']);?>?item_id=${item_id}`)
        .then((response) => {
            return response.json();
        })
        .then(function(result) {
            setSpanLikeDislike(element, result);
        });
    }
    function dislike(item_id, element) {
        fetch(`<?=Url::to(['like/dislike']);?>?item_id=${item_id}`)
        .then((response) => {
            return response.json();
        })
        .then(function(result) {
            setSpanLikeDislike(element, result);
        });
    }
</script>