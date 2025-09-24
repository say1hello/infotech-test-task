<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "subscriber".
 *
 * @property int $id
 * @property string $phone Номер телефона
 * @property int $author_id Автор
 * @property int $active Активность подписки
 * @property int $created_at Дата и время создания
 * @property int $updated_at Дата и время последнего редактирования
 *
 * @property Author $author
 */
class Subscriber extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscriber';
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
            [['active'], 'default', 'value' => 1],
            [['phone', 'author_id'], 'required'],
            [['author_id', 'active'], 'integer'],
            [['phone'], 'string', 'min' => 11, 'max' => 11],
            [['phone', 'author_id'], 'unique', 'targetAttribute' => ['phone', 'author_id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Номер телефона',
            'author_id' => 'Автор',
            'active' => 'Активность подписки',
            'created_at' => 'Дата и время создания',
            'updated_at' => 'Дата и время последнего редактирования',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}
