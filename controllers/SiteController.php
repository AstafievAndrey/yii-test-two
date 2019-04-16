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
use app\models\User;
use app\models\tables\Items;
use app\models\tables\Users;
use app\models\tables\Ratings;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($page = 1)
    {
        $query = Items::find();
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 12
        ]);
        $products = $query->offset($pages->offset)->limit($pages->limit);
        return $this->render('index', [
            'items' => $query->all(),
            'pages' => $pages,
            'guest' => Yii::$app->user->isGuest
        ]);
    }

    public function actionView($name)
    {
        return $this->render('view', [
            'item' => Items::find()->where([ 'translite' => $name])->one()
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin($code = null)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $vk = new Vk();
        if (is_null($code)) {
            return $this->render('login', ['vkAuth' => $vk->getLink()]);
        }
        $response = $vk->getAccessToken($code);
        if (isset($response->error)) {
            return $this->render('error', [
                'name'=>'Авторизация',
                'message' => $response->error_description
            ]);
        }
        $userInfo = $vk->getUser($response->user_id, $response->access_token);
        $user = Users::find()->where(['vk_user_id' => $response->user_id])->one();
        if(is_null($user)) {
            $user = new Users();
            $user->vk_user_id = $response->user_id;
            $user->first_name = $userInfo->response[0]->first_name;
            $user->last_name = $userInfo->response[0]->last_name;
            $user->access_token = $response->access_token;
            $user->expires_in = $response->expires_in;
            $user->save();
        } else {
            $user->access_token = $response->access_token;
            $user->expires_in = $response->expires_in;
            $user->save();
        }

        Yii::$app->user->login(User::findIdentity($user->id), 0);
        $this->redirect('index');
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionTest($name)
    {
        var_dump($name);
    }
}
