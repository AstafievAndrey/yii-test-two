<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\Vk;
use app\models\tables\Ratings;
use app\models\tables\Users;
use app\models\User;

class LikeController extends Controller
{

    public function behaviors()
    {
        Yii::$app->response->format = Response::FORMAT_JSON; 
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'dislike'],
                'rules' => [
                    [
                        'actions' => ['index', 'dislike'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    private function save(int $item_id, string $type): Ratings {
        $rating = Ratings::findOne([
            'user_id' => Yii::$app->user->identity->id,
            'item_id' => $item_id
        ]);
        if (is_null($rating)) {
            $rating = new Ratings();
            $rating->user_id = Yii::$app->user->identity->id;
            $rating->item_id = $item_id;
            $rating->type = $type;
            $rating->save();
        } else {
            $rating->type = $type;
            $rating->save();
        }
        return $rating;
    }

    public function actionIndex(int $item_id)
    {
        return $this->save($item_id, 'like');
    }

    public function actionDislike($item_id)
    {
        return $this->save($item_id, 'dislike');
    }

}
