<?php

use yii\db\Migration;

/**
 * Class m190405_222105_items_categories
 */
class m190405_222105_items_categories extends Migration
{
    private function getMock($foreignOne, $foreignTwo) 
    {
        return [
            [
                'id' => 1,
                $foreignOne => 1, 
                $foreignTwo => 1
            ],
            [
                'id' => 2,
                $foreignOne => 2, 
                $foreignTwo => 2
            ],
            [
                'id' => 3,
                $foreignOne => 3, 
                $foreignTwo => 3
            ],
            [
                'id' => 4,
                $foreignOne => 4, 
                $foreignTwo => 1
            ],
            [
                'id' => 5,
                $foreignOne => 5, 
                $foreignTwo => 2
            ],
        ];
    }

    public function safeUp()
    {
        $table = 'items_categories';
        $foreignOne = 'item_id';
        $foreignTwo = 'category_id';
        $refTableOne = 'items';
        $refTableTwo = 'categories';
        $this->createTable($table, [
            'id' => $this->primaryKey(),
            $foreignOne => $this->integer()->notNull()->comment('связь на таблицу '.$refTableOne.'.'),
            $foreignTwo => $this->integer()->notNull()->comment('связь на таблицу images '.$refTableTwo.'.'),
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
        foreach($this->getMock($foreignOne, $foreignTwo) as $value) {
            $this->insert($table, $value);
        }
    }

    public function safeDown()
    {
        $this->dropTable('items_categories');
        return true;
    }
}
