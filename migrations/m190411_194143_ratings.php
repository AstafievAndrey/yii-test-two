<?php

use yii\db\Migration;

/**
 * Class m190411_194143_ratings
 */
class m190411_194143_ratings extends Migration
{

    public function safeUp()
    {
        $this->dropColumn('items', 'count_votes');
        $this->dropColumn('items', 'sum_votes');
        $this->createTable('ratings', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('Ид пользователя.'),
            'item_id' => $this->integer()->notNull()->comment('Ид объекта'),
            'type' => "ENUM('like', 'dislike')",
            'create_at' => 'datetime DEFAULT NOW()',
            'update_at' => 'datetime ON UPDATE NOW()',
        ]);
        $this->createIndex(
            'idx-ratings-type',
            'ratings',
            'type'
        );
        $this->addForeignKey(
            'fk-ratings-user_id', 'ratings', 'user_id', 'users', 'id', 'CASCADE'
        );
        $this->addForeignKey(
            'fk-ratings-item_id', 'ratings', 'item_id', 'items', 'id', 'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->addColumn('items', 'count_votes', $this->integer()->comment('Количество голосов.'));
        $this->addColumn('items', 'sum_votes', $this->integer()->comment('Сумма голосов.'));
        $this->dropTable('ratings');
        return true;
    }
}
