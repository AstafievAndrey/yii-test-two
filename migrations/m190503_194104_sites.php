<?php

use yii\db\Migration;

/**
 * Class m190503_194104_sites
 */
class m190503_194104_sites extends Migration
{

    public function safeUp()
    {
        $this->createTable('sites', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->notNull()->comment('Ид объекта'),
            'name' => $this->string()->comment('Адрес сайта'),
            'create_at' => 'datetime DEFAULT NOW()',
            'update_at' => 'datetime ON UPDATE NOW()',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('sites');
        return true;
    }
}
