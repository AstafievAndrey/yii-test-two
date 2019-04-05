<?php

use yii\db\Migration;

/**
 * Class m190405_220139_items_images
 */
class m190405_220139_items_images extends Migration
{
    public function safeUp()
    {
        $table = 'items_images';
        $foreignOne = 'item_id';
        $foreignTwo = 'image_id';
        $refTableOne = 'items';
        $refTableTwo = 'images';
        $this->createTable($table, [
            'id' => $this->primaryKey(),
            $foreignOne => $this->integer()->notNull()->comment('связь на таблицу items.'),
            $foreignTwo => $this->integer()->notNull()->comment('связь на таблицу images.'),
            'create_at' => 'datetime DEFAULT NOW()',
            'update_at' => 'datetime ON UPDATE NOW()',
            'update_user_id' => $this->integer()->comment('Ид пользователя редактирующий информацию последним.'),
            'delete_at' => $this->datetime(),
        ]);
        $this->addForeignKey(
            'fk-'.$table.'-'.$foreignOne, $table, $foreignOne, $refTableOne, 'id', 'CASCADE'
        );
        $this->addForeignKey(
            'fk-'.$table.'-'.$foreignTwo, $table, $foreignTwo, $refTableTwo, 'id', 'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('items_images');
        return true;
    }
}
