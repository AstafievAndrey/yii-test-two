<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Url;

use app\models\Vk;
use app\models\User;
use app\models\tables\Items;
use app\models\tables\Users;
use app\models\tables\Cities;
use app\models\tables\Categories;

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
     * Отобразим главную страницу
     */
    public function actionIndex()
    {
        $this->redirect(Url::toRoute('/list'));
    }

    /**
     * @param string $city - параметр поиска по городу
     * @param string $category - параметр поиска по категории
     * @param string $rating - параметр поиска по лайкам/дизлайкам
     * @return string
     */
    public function actionList($city = '', $category = '', $rating = 'like')
    {
        $query = Items::getQueryFilter($city, $category, $rating);
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 12,
            'route' => Url::to('list')
        ]);
        $products = $query->offset($pages->offset)->limit($pages->limit);
        return $this->render('index', [
            'guest' => Yii::$app->user->isGuest,
            'items' => $products->all(),
            'pages' => $pages,
            'cities' => Cities::findAll(['delete_at' => null]),
            'categories' => Categories::findAll(['delete_at' => null]),
            'selectedCity' => $city,
            'selectedCategory' => $category,
            'selectedRating' => $rating,
        ]);
    }



    public function actionView($name)
    {
        return $this->render('view', [
            'item' => Items::find()->where([ 'translite' => $name])->one()
        ]);
    }

    /**
     * Страница для авторизации на сайте через ВК
     *
     * @param string $code - код от вк для авторизации
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
}
