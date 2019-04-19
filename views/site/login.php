<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;

$this->title = 'Авторизация на сайте';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
     <p>Авторизовать на сайте можно через социальную сеть ВКонтакте.</p>
     <a class="btn btn-primary" href="<?=$vkAuth?>">войти</a>
</div>
