<?php

namespace app\models;

use yii\base\Model;

/**
 * This is the form class for table "subscriber".
 *
 * @property string $phone Номер телефона
 *
 * @property Author $author
 */
class SubscribeForm extends Model
{
    public string $phone = '';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['phone'], 'string', 'min' => 11, 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'phone' => 'Номер телефона',
        ];
    }
}