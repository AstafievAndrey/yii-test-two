<?php

namespace app\models;
use app\models\tables\Users;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $vk_user_id;
    public $access_token;
    public $first_name;
    public $last_name;
    public $expires_in;
    public $create_at;
    public $update_at;
    public $delete_at;

    public static function findIdentity($id)
    {
        $user = Users::findOne((int)$id);
        return $user ? new static($user) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = Users::find()->where(['access_token' => $token])->one();
        return $user ? new static($user): null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->access_token;
    }

    public function validateAuthKey($accessToken)
    {
        return $this->access_token === $accessToken;
    }
}
