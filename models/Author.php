<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $name ФИО
 *
 * @property BookAuthor[] $bookAuthors
 * @property Book[] $books
 * @property Subscriber[] $subscribers
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            // Or with custom configuration:
            // [
            //     'class' => TimestampBehavior::class,
            //     'createdAtAttribute' => 'my_created_field',
            //     'updatedAtAttribute' => 'my_updated_field',
            //     'value' => new \yii\db\Expression('NOW()'), // Use database expression for datetime
            // ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ФИО',
            'created_at' => 'Дата и время создания',
            'updated_at' => 'Дата и время последнего редактирования',
        ];
    }

    public function getBookAuthors(): ActiveQuery
    {
        return $this->hasMany(BookAuthor::class, ['author_id' => 'id']);
    }

    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])->viaTable('book_author', ['author_id' => 'id']);
    }

    public function getSubscribers(): ActiveQuery
    {
        return $this->hasMany(Subscriber::class, ['author_id' => 'id']);
    }
}