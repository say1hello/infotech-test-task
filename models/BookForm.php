<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * This is the form class for table "book".
 *
 * @property int|null $id
 * @property string $title название
 * @property int $pub_year год выпуска
 * @property string $description описание
 * @property string $isbn isbn
 * @property string $photo фото главной страницы
 * @property array $authorsIds id авторов
 * @property UploadedFile|null $imageFile
 */
class BookForm extends Model
{
    public ?int $id = null;
    public string $title = '';
    public string $pub_year = '';
    public string $description = '';
    public string $isbn = '';
    public string $photo = '';
    public array $authorsIds = [];

    public UploadedFile|string|null $imageFile = null;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'pub_year', 'description', 'isbn', 'authorsIds'], 'required'],
            [
                ['imageFile'],
                'required',
                'when' => function ($model) {
                    return !$model->photo;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#bookform-photo').length == 0;
                }"
            ],
            [['id'], 'integer'],
            [['pub_year'], 'date', 'format' => 'yyyy', 'min' => '1900', 'max' => date('Y')],
            [['description'], 'string'],
            [['title', 'photo'], 'string', 'max' => 255],
            [['isbn'], 'string', 'min' => 13, 'max' => 13],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['authorsIds'], 'each', 'rule' => ['integer']],
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
            'imageFile' => 'фото главной страницы',
            'authorsIds' => 'авторы',
        ];
    }

    public function save(?Book $model = null): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $model = $model ?? new Book();

        $model->load($this->attributes, '');

        if ($this->imageFile) {
            $model->deletePhoto();
            $fileName = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
            $filePath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $fileName;
            try {
                if ($this->imageFile->saveAs($filePath)) {
                    $model->photo = 'uploads' . DIRECTORY_SEPARATOR . $fileName;
                } else {
                    $this->addError('imageFile', 'Произошла ошибка во время сохранения файла');
                }
            } catch (\Throwable $exception) {
                $this->addError('imageFile', 'Произошла ошибка во время сохранения файла');
            }
        }

        if ($this->hasErrors()) {
            return false;
        }

        if ($model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save(false)) {
                    $model->unlinkAll('authors', true);
                    foreach ($this->authorsIds as $authorId) {
                        $authorModel = Author::findOne($authorId);
                        if (!$authorModel) {
                            throw new NotFoundHttpException('Автор с id#' . $authorId . ' не найден.');
                        }
                        $model->link('authors', $authorModel);
                    }
                    $transaction->commit();
                    $this->id = $model->id;
                    return true;
                }
            } catch (\Throwable $exception) {
                $transaction->rollBack();
            }
        } else {
            $this->addErrors($model->getErrors());
        }

        return false;
    }
}
