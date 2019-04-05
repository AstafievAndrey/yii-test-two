<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property int $id
 * @property string $name Название обекта.
 * @property string $translite Транслит названия обекта.
 * @property string $description Описание обекта для сео.
 * @property string $keys Ключевые слова для сео.
 * @property string $about Описание объекта.
 * @property int $count_votes Количество голосов.
 * @property int $sum_votes Сумма голосов.
 * @property string $create_at
 * @property string $update_at
 * @property int $update_user_id Ид пользователя редактирующий информацию последним.
 * @property string $delete_at
 *
 * @property ItemsCategories[] $itemsCategories
 * @property ItemsCities[] $itemsCities
 * @property ItemsImages[] $itemsImages
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'translite', 'description'], 'required'],
            [['description', 'keys', 'about'], 'string'],
            [['count_votes', 'sum_votes', 'update_user_id'], 'integer'],
            [['create_at', 'update_at', 'delete_at'], 'safe'],
            [['name', 'translite'], 'string', 'max' => 255],
            [['translite'], 'unique'],
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
            'about' => 'About',
            'count_votes' => 'Count Votes',
            'sum_votes' => 'Sum Votes',
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
        return $this->hasMany(ItemsCategories::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemsCities()
    {
        return $this->hasMany(ItemsCities::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemsImages()
    {
        return $this->hasMany(ItemsImages::className(), ['item_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemsQuery(get_called_class());
    }
}
