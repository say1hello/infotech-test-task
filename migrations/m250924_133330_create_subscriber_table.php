<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriber}}`.
 */
class m250924_133330_create_subscriber_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriber}}', [
            'id' => $this->primaryKey(),
            'phone' => $this->string('11')->notNull()->comment('Номер телефона'),
            'author_id' => $this->integer()->notNull()->comment('Автор'),
            'active' => $this->boolean()->notNull()->defaultValue(true)->comment('Активность подписки'),
            'created_at' => $this->integer(11)->notNull()->comment('Дата и время создания'),
            'updated_at' => $this->integer(11)->notNull()->comment('Дата и время последнего редактирования'),
        ]);
        $this->createIndex(
            '{{%idx-unique-subscriber-phone-author_id}}',
            '{{%subscriber}}',
            ['phone', 'author_id'],
            true
        );
        $this->createIndex(
            '{{%idx-subscriber-author_id}}',
            '{{%subscriber}}',
            'author_id'
        );
        $this->addForeignKey(
            '{{%fk-subscriber-author_id}}',
            '{{%subscriber}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-subscriber-author_id}}',
            '{{%subscriber}}'
        );
        $this->dropIndex(
            '{{%idx-subscriber-author_id}}',
            '{{%subscriber}}'
        );
        $this->dropTable('{{%subscriber}}');
    }
}
