<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string $name Название файла.
 * @property string $type Тип файла.
 * @property int $size Размер файла.
 * @property resource $blob Ячейка с файлом.
 * @property string $create_at
 * @property string $update_at
 * @property int $update_user_id Ид пользователя редактирующий информацию последним.
 * @property string $delete_at
 *
 * @property ItemsImages[] $itemsImages
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'size', 'blob'], 'required'],
            [['name', 'type', 'blob'], 'string'],
            [['size', 'update_user_id'], 'integer'],
            [['create_at', 'update_at', 'delete_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'size' => 'Size',
            'blob' => 'Blob',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'update_user_id' => 'Update User ID',
            'delete_at' => 'Delete At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemsImages()
    {
        return $this->hasMany(ItemsImages::className(), ['image_id' => 'id']);
    }
}
