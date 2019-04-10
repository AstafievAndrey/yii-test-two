<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\LoginForm;
use app\models\Vk;
use app\models\tables\Items;

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
        $vk = new Vk();
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
            'vkAuth' => $vk->getLink()
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
    public function actionLogin($code = null, $access_token = null)
    {
        $vk = new Vk();
        if (is_null($code)) {
            return;
        }
        $response = json_decode('{"access_token":"537b0eb6e5a01aae2cf889eff16f10f3883a5bb256badd43b3aeff631b4c119ae4cba8f583c0b756bb8d7","expires_in":0,"user_id":71803813}');
        var_dump($response);
        
        // if (!Yii::$app->user->isGuest) {
        //     return $this->goHome();
        // }

        // $model = new LoginForm();
        // if ($model->load(Yii::$app->request->post()) && $model->login()) {
        //     return $this->goBack();
        // }

        // $model->password = '';
        // return $this->render('login', [
        //     'model' => $model,
        // ]);
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
}
