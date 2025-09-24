<?php

namespace app\controllers;

use app\models\Author;
use app\models\Book;
use app\models\BookForm;
use app\models\BookSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['create', 'update', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $formModel = new BookForm();
        $authors = Author::find()->all();

        if ($this->request->isPost) {
            $formModel->load($this->request->post());
            $formModel->imageFile = UploadedFile::getInstance($formModel, 'imageFile');
            if ($formModel->save()) {
                \Yii::$app->session->setFlash('success', 'Новая книга успешно добавлена');
                return $this->redirect(['view', 'id' => $formModel->id]);
            } else {
                \Yii::$app->session->setFlash('error', 'Во время добавления книги произошли ошибки');
            }
        }

        return $this->render('create', [
            'formModel' => $formModel,
            'authors' => $authors,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id, true);
        $formModel = new BookForm();
        $formModel->load($model->attributes, '');
        $formModel->setAttributes(['authorsIds' => ArrayHelper::getColumn($model->authors, 'id')]);
        $authors = Author::find()->all();

        if ($this->request->isPost) {
            $formModel->load($this->request->post());
            $formModel->imageFile = UploadedFile::getInstance($formModel, 'imageFile');
            if ($formModel->save($model)) {
                \Yii::$app->session->setFlash('success', 'Книга успешно обновлена');
                return $this->redirect(['view', 'id' => $formModel->id]);
            } else {
                \Yii::$app->session->setFlash('error', 'Во время обновления книги произошли ошибки');
            }
        }

        return $this->render('update', [
            'formModel' => $formModel,
            'authors' => $authors,
        ]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, bool $withAuthors = false)
    {
        $query = Book::find()->where([Book::tableName() . '.id' =>$id]);

        if ($withAuthors) {
            $query->joinWith('authors');
        }

        if (($model = $query->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
