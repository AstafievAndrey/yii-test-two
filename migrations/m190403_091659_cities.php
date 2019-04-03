<?php

use yii\db\Migration;

/**
 * Class m190403_091659_cities
 */
class m190403_091659_cities extends Migration
{
    private function getCities() {
        return [
            [
                'id'=> 1, 
                'name' => 'Казань', 
                'translite' => 'Kazan', 
                'description' => 'Республика Татарстан город Казань',
                'keys' => 'Казань, Татарстан, каталог, город'
            ],
            [
                'id'=> 2, 
                'name' => 'Уфа', 
                'translite' => 'Ufa', 
                'description' => 'Республика Башкирия город Уфа',
                'keys' => 'Уфа, Башкирия, каталог, город'
            ],
            [
                'id'=> 3, 
                'name' => 'Йошкар-Ола', 
                'translite' => 'Joshkar-Ola', 
                'description' => 'Республика Марий Эл город Йошкар-Ола',
                'keys' => 'Йошкар-Ола, Марий Эл, каталог, город'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cities', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название города.'),
            'translite' => $this->string()->notNull()->comment('Транслит названия города.'),
            'description' => $this->text()->notNull()->comment('Описание города для сео.'),
            'keys' => $this->text()->comment('Ключевые слова для сео.'),
            'create_at' => 'datetime DEFAULT NOW()',
            'update_at' => 'datetime ON UPDATE NOW()',
            'update_user_id' => $this->integer()->comment('Ид пользователя редактирующий информацию последним.'),
            'delete_at' => $this->datetime(),
        ]);
        foreach($this->getCities() as $value) {
            $this->insert('cities', $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cities');

        return true;
    }
}
