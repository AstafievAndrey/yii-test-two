<?php

namespace app\controllers\personal;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

use app\models\tables\Cities;
use app\models\tables\Categories;

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
        return $this->actionAddForm();
    }

    public function actionAddForm()
    {
        $this->getView()->registerJsFile (
            '@web/js/add-form.js',
            ['position' => \yii\web\View::POS_END]
        );
        return $this->render('add-form', [
            'cities' => Cities::findAll(['delete_at' => null]),
            'categories' => Categories::findAll(['delete_at' => null])
        ]);
    }
}