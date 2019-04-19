<?php

namespace app\controllers\personal;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class MainController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create'],
                'rules' => [
                    [
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('create');
    }

    public function actionCreate()
    {
        return $this->render('create');
    }
}