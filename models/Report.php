<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AuthorsSearch represents the model behind the search form of `app\models\Authors`.
 */
class Report extends Book
{
    public string $authorName = '';
    public int $booksCount = 0;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pub_year'], 'required'],
            [['pub_year'], 'date', 'format' => 'yyyy', 'min' => '1900', 'max' => date('Y')],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'booksCount' => 'Количество книг',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function formName()
    {
        return '';
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = self::find()
            ->select([Author::tableName() . '.name AS authorName', 'COUNT(*) AS booksCount'])
            ->joinWith('authors')
            ->groupBy([BookAuthor::tableName() . '.author_id'])
            ->orderBy(['booksCount' => SORT_DESC])
            ->limit(10);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->where([
            'pub_year' => $this->pub_year,
        ]);

        return $dataProvider;
    }
}
