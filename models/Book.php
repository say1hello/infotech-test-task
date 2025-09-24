<?php

namespace app\models;

use app\services\SubscribeService;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title название
 * @property int $pub_year год выпуска
 * @property string $description описание
 * @property string $isbn isbn
 * @property string $photo фото главной страницы
 *
 * @property Author[] $authors
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
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
            [['title', 'pub_year', 'description', 'isbn', 'photo'], 'required'],
//            [['pub_year'], 'integer'],
            [['pub_year'], 'string', 'min' => 4, 'max' => 4],
            [['description'], 'string'],
            [['title', 'photo'], 'string', 'max' => 255],
            [['isbn'], 'string', 'min' => 13, 'max' => 13],
            [['isbn'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'название',
            'pub_year' => 'год выпуска',
            'description' => 'описание',
            'isbn' => 'isbn',
            'photo' => 'фото главной страницы',
            'authors' => 'авторы',
            'created_at' => 'Дата и время создания',
            'updated_at' => 'Дата и время последнего редактирования',
        ];
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->viaTable('book_author', ['book_id' => 'id']);
    }

    public function deletePhoto(): void
    {
        if ($this->photo) {
            $filePath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . $this->photo;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            foreach ($this->authors as $author) {
                foreach ($author->subscribers as $subscriber) {
                    SubscribeService::notify($subscriber->phone, $author->name, $this->title);
                }
            }
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $this->deletePhoto();
    }

}
