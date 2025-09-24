<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m250923_203300_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string('255')->notNull()->comment('название'),
            'pub_year' => $this->integer(4)->notNull()->comment('год выпуска'),
            'description' => $this->text()->notNull()->comment('описание'),
            'isbn' => $this->string('13')->unique()->notNull()->comment('isbn'),
            'photo' => $this->string('255')->notNull()->comment('фото главной страницы'),
            'created_at' => $this->integer(11)->notNull()->comment('Дата и время создания'),
            'updated_at' => $this->integer(11)->notNull()->comment('Дата и время последнего редактирования'),
        ]);
        $this->createIndex(
            'idx-book-title',
            '{{%book}}',
            'title');
        $this->createIndex(
            'idx-book-isbn',
            '{{%book}}',
            'isbn');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-book-title',
            '{{%book}}'
        );
        $this->dropIndex(
            'idx-book-isbn',
            '{{%book}}'
        );
        $this->dropTable('{{%book}}');
    }
}
