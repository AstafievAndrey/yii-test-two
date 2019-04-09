<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "items_cities".
 *
 * @property int $id
 * @property int $item_id связь на таблицу items.
 * @property int $city_id связь на таблицу images cities.
 * @property string $create_at
 * @property string $update_at
 * @property int $update_user_id Ид пользователя редактирующий информацию последним.
 * @property string $delete_at
 *
 * @property Cities $city
 * @property Items $item
 */
class ItemsCities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items_cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'city_id'], 'required'],
            [['item_id', 'city_id', 'update_user_id'], 'integer'],
            [['create_at', 'update_at', 'delete_at'], 'safe'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Items::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'city_id' => 'City ID',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'update_user_id' => 'Update User ID',
            'delete_at' => 'Delete At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Items::className(), ['id' => 'item_id']);
    }
}
