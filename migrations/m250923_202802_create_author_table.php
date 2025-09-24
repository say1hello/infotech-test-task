<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author}}`.
 */
class m250923_202802_create_author_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string('255')->unique()->notNull()->comment('ФИО'),
            'created_at' => $this->integer(11)->notNull()->comment('Дата и время создания'),
            'updated_at' => $this->integer(11)->notNull()->comment('Дата и время последнего редактирования'),
        ]);
        $this->createIndex(
            'idx-author-name',
            '{{%author}}',
            'name'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-author-name',
            '{{%author}}'
        );
        $this->dropTable('{{%author}}');
    }
}
