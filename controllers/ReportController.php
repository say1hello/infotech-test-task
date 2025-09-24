<?php

namespace app\controllers;

use app\models\Report;
use yii\web\Controller;

/**
 * AuthorsController implements the CRUD actions for Authors model.
 */
class ReportController extends Controller
{
    /**
     * Lists all Authors models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new Report();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
