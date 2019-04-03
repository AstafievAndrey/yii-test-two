<?php

use yii\db\Migration;

/**
 * Class m190403_100910_categories
 */
class m190403_100910_categories extends Migration
{
    private function getCategories() {
        return [
            [
                'id'=> 1, 
                'name' => 'Дома', 
                'translite' => 'Homes', 
                'description' => 'Категория домов',
                'keys' => 'Категория, дома, home, каталог'
            ],
            [
                'id'=> 2, 
                'name' => 'Магазины', 
                'translite' => 'Shops', 
                'description' => 'Категория домов',
                'keys' => 'Категория, магазины, shops, каталог'
            ],
            [
                'id'=> 3, 
                'name' => 'Кафе', 
                'translite' => 'Cafe', 
                'description' => 'Категория кафе',
                'keys' => 'Категория, кафе, cafe, каталог'
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название категории.'),
            'translite' => $this->string()->notNull()->comment('Транслит названия категории.'),
            'description' => $this->text()->notNull()->comment('Описание категории для сео.'),
            'keys' => $this->text()->comment('Ключевые слова для сео.'),
            'create_at' => 'datetime DEFAULT NOW()',
            'update_at' => 'datetime ON UPDATE NOW()',
            'update_user_id' => $this->integer()->comment('Ид пользователя редактирующий информацию последним.'),
            'delete_at' => $this->datetime(),
        ]);
        foreach($this->getCategories() as $value) {
            $this->insert('categories', $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('categories');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190403_100910_categories cannot be reverted.\n";

        return false;
    }
    */
}
