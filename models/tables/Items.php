<?php

namespace app\models\tables;

use Yii;
use app\models\tables\Ratings;

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

    public function getRatingUser(int $id)
    {
        return Ratings::findOne(['user_id' => $id, 'item_id' => $this->id]);
    }

    public function getCountRatingType(string $type)
    {
        return Ratings::find()
                ->where(['item_id' => $this->id, 'type' => $type])
                ->count();
    }

    /**
     * @param $city
     * @param $category
     * @param $rating
     * @return ItemsQuery
     */
    public static function getQueryFilter($city, $category, $rating)
    {
        $query = Items::find()->select('items.*');
        $query->addSelect('(select count(*) from ratings r where r.item_id = items.id and type = \'like\') as rating_like');
        $query->addSelect('(select count(*) from ratings r where r.item_id = items.id and type = \'dislike\') as rating_dislike');
        if(!empty($city)) {
            $query->innerJoin( 'items_cities', 'items_cities.item_id = items.id');
            $query->innerJoin( 'cities', 'cities.id = items_cities.city_id');
            $query->andWhere(['cities.translite' => $city]);
        }
        if(!empty($category)) {
            $query->innerJoin( 'items_categories', 'items_categories.item_id = items.id');
            $query->innerJoin( 'categories', 'categories.id = items_categories.category_id');
            $query->andWhere(['categories.translite' => $category]);
        }
        $query->orderBy(($rating === 'like' ? 'rating_like' : 'rating_dislike').' desc');
        return $query;
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
