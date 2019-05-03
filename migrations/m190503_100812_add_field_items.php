<?php

use yii\db\Migration;

/**
 * Class m190503_100812_add_field_items
 */
class m190503_100812_add_field_items extends Migration
{

    public function safeUp()
    {
        $this->addColumn(
            'items',
            'create_user_id',
            $this->integer()->notNull()
                ->comment('Ид пользователя добавившего запись')
        );
        $this->addColumn(
            'items',
            'status',
            'ENUM(\'TRASH\', \'WARNING\', \'SUCCESS\', \'MODERATION\') NOT NULL DEFAULT \'MODERATION\' '
                    .'COMMENT \'Статус записи трэш/TRASH, успех/SUCCESS, на модерации/MODERATION, заполнена не правильно/WARNING\''
        );

        $this->execute('update items set create_user_id = 1');
        $this->addForeignKey(
            'fk-items-create_user_id',
            'items',
            'create_user_id',
            'users',
            'id'
        );
        $this->addForeignKey(
            'fk-items-update_user_id',
            'items',
            'update_user_id',
            'users',
            'id'
        );

        $this->createIndex(
            'idx-items-status',
            'items',
            'status'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-items-create_user_id', 'items');
        $this->dropForeignKey('fk-items-update_user_id', 'items');
        $this->dropColumn('items', 'create_user_id');
        $this->dropColumn('items', 'status');

        return true;
    }

}
