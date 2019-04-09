<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name Название категории.
 * @property string $translite Транслит названия категории.
 * @property string $description Описание категории для сео.
 * @property string $keys Ключевые слова для сео.
 * @property string $create_at
 * @property string $update_at
 * @property int $update_user_id Ид пользователя редактирующий информацию последним.
 * @property string $delete_at
 *
 * @property ItemsCategories[] $itemsCategories
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'translite', 'description'], 'required'],
            [['description', 'keys'], 'string'],
            [['create_at', 'update_at', 'delete_at'], 'safe'],
            [['update_user_id'], 'integer'],
            [['name', 'translite'], 'string', 'max' => 255],
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
            'translite' => 'Translite',
            'description' => 'Description',
            'keys' => 'Keys',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'update_user_id' => 'Update User ID',
            'delete_at' => 'Delete At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemsCategories()
    {
        return $this->hasMany(ItemsCategories::className(), ['category_id' => 'id']);
    }
}
