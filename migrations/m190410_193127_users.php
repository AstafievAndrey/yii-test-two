<?php

use yii\db\Migration;

/**
 * Class m190410_193127_users
 */
class m190410_193127_users extends Migration
{
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'vk_user_id' => $this->integer()->notNull()->comment('Ид пользователя от вк.')->unique(),
            'access_token' => $this->text()->notNull()->comment('Ключ доступа от вк.'),
            'first_name' => $this->string()->comment('Фамилия пользователя.'),
            'last_name' => $this->string()->comment('Имя пользователя.'),
            'expires_in' => $this->integer()->comment('Время жизни токена.'),
            'create_at' => 'datetime DEFAULT NOW()',
            'update_at' => 'datetime ON UPDATE NOW()',
            'delete_at' => $this->datetime(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('users');
        return true;
    }
}
