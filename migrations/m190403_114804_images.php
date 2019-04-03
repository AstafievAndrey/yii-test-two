<?php

use yii\db\Migration;

/**
 * Class m190403_114804_images
 */
class m190403_114804_images extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('images', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->notNull()->comment('Название файла.'),
            'type' => $this->text()->notNull()->comment('Тип файла.'),
            'size' => $this->integer()->notNull()->comment('Размер файла.'),
            'blob' => $this->binary()->notNull()->comment('Ячейка с файлом.'),
            'create_at' => 'datetime DEFAULT NOW()',
            'update_at' => 'datetime ON UPDATE NOW()',
            'update_user_id' => $this->integer()->comment('Ид пользователя редактирующий информацию последним.'),
            'delete_at' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('images');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190403_114804_images cannot be reverted.\n";

        return false;
    }
    */
}
