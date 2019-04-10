<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int $vk_user_id Ид пользователя от вк.
 * @property string $access_token Ключ доступа от вк.
 * @property string $first_name Фамилия пользователя.
 * @property string $last_name Имя пользователя.
 * @property int $expires_in Время жизни токена.
 * @property string $create_at
 * @property string $update_at
 * @property string $delete_at
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vk_user_id', 'access_token'], 'required'],
            [['vk_user_id', 'expires_in'], 'integer'],
            [['access_token'], 'string'],
            [['create_at', 'update_at', 'delete_at'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['vk_user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vk_user_id' => 'Vk User ID',
            'access_token' => 'Access Token',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'expires_in' => 'Expires In',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'delete_at' => 'Delete At',
        ];
    }
}
