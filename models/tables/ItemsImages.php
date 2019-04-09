<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "items_images".
 *
 * @property int $id
 * @property int $item_id связь на таблицу items
 * @property int $image_id связь на таблицу images
 * @property string $create_at
 * @property string $update_at
 * @property int $update_user_id Ид пользователя редактирующий информацию последним.
 * @property string $delete_at
 *
 * @property Images $image
 * @property Items $item
 */
class ItemsImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'image_id'], 'required'],
            [['item_id', 'image_id', 'update_user_id'], 'integer'],
            [['create_at', 'update_at', 'delete_at'], 'safe'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Images::className(), 'targetAttribute' => ['image_id' => 'id']],
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
            'image_id' => 'Image ID',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'update_user_id' => 'Update User ID',
            'delete_at' => 'Delete At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Images::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Items::className(), ['id' => 'item_id']);
    }
}
