<?php

use yii\db\Migration;

/**
 * Class m190403_115507_items
 */
class m190403_115507_items extends Migration
{
    const LOREMIPSUM = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis varius quam quisque id diam vel. Elit duis tristique sollicitudin nibh. Lorem ipsum dolor sit amet consectetur adipiscing elit ut aliquam. Integer enim neque volutpat ac tincidunt. Interdum posuere lorem ipsum dolor sit amet consectetur. Tortor vitae purus faucibus ornare suspendisse sed nisi. Neque volutpat ac tincidunt vitae. Varius sit amet mattis vulputate. Id cursus metus aliquam eleifend mi in. Scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam malesuada. Morbi tristique senectus et netus et. Tristique senectus et netus et malesuada fames ac turpis egestas.';
    private function getItems() 
    {
        return [
            [
                'id' => 1,
                'name' => 'Тестовая запись номер один',
                'translite' => 'test-number-one',
                'description' => 'Описание для тестовой записи номер один.',
                'keys' => 'Обект, название',
                'about' => SELF::LOREMIPSUM,
                'count_votes' => 120,
                'sum_votes' => 500,
            ],
            [
                'id' => 2,
                'name' => 'Тестовая запись номер два',
                'translite' => 'test-number-two',
                'description' => 'Описание для тестовой записи номер два.',
                'keys' => 'Обект, название',
                'about' => SELF::LOREMIPSUM,
                'count_votes' => 110,
                'sum_votes' => 400,
            ],
            [
                'id' => 3,
                'name' => 'Тестовая запись номер три',
                'translite' => 'test-number-three',
                'description' => 'Описание для тестовой записи номер три.',
                'keys' => 'Обект, название',
                'about' => SELF::LOREMIPSUM,
                'count_votes' => 200,
                'sum_votes' => 500,
            ],
            [
                'id' => 4,
                'name' => 'Тестовая запись номер четыре',
                'translite' => 'test-number-four',
                'description' => 'Описание для тестовой записи номер четыре.',
                'keys' => 'Обект, название',
                'about' => SELF::LOREMIPSUM,
                'count_votes' => 90,
                'sum_votes' => 300,
            ],
            [
                'id' => 5,
                'name' => 'Тестовая запись номер пять',
                'translite' => 'test-number-five',
                'description' => 'Описание для тестовой записи номер пять.',
                'keys' => 'Обект, название',
                'about' => SELF::LOREMIPSUM,
                'count_votes' => 150,
                'sum_votes' => 500,
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('items', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Название обекта.'),
            'translite' => $this->string()->notNull()->comment('Транслит названия обекта.')->unique(),
            'description' => $this->text()->notNull()->comment('Описание обекта для сео.'),
            'keys' => $this->text()->comment('Ключевые слова для сео.'),
            'about' => $this->text()->comment('Описание объекта.'),
            'count_votes' => $this->integer()->comment('Количество голосов.'),
            'sum_votes' => $this->integer()->comment('Сумма голосов.'),
            'create_at' => 'datetime DEFAULT NOW()',
            'update_at' => 'datetime ON UPDATE NOW()',
            'update_user_id' => $this->integer()->comment('Ид пользователя редактирующий информацию последним.'),
            'delete_at' => $this->datetime(),
        ]);
        foreach($this->getItems() as $value) {
            $this->insert('items', $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('items');

        return true;
    }
}
