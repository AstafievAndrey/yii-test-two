<?php

use yii\db\Migration;

/**
 * Class m190405_223058_items_cities
 */
class m190405_223058_items_cities extends Migration
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
        $table = 'items_cities';
        $foreignOne = 'item_id';
        $foreignTwo = 'city_id';
        $refTableOne = 'items';
        $refTableTwo = 'cities';
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
