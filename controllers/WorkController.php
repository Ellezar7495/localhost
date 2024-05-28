<?php

namespace app\controllers;

use app\models\Category;
use app\models\Comment;
use app\models\Like;
use app\models\Search;
use app\models\Work;
use app\models\WorkCategory;
use app\models\WorkCollection;
use app\models\WorkSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * WorkController implements the CRUD actions for Work model.
 */
class WorkController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'error' => [
                            'class' => 'yii\web\ErrorAction',
                        ],
                    ],
                ],


            ]
        );
    }

    /**
     * Lists all Work models.
     *
     * @return string
     */
    public function actions()
    {
        if (Yii::$app->user->isGuest) {
            $this->goHome();
        }
    }
    public function actionIndex()
    {
        $searchModel = new WorkSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Work model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if (Yii::$app->request->post('type') == 'create') {
                $modelLike = new Like();
                $modelLike->user_id = Yii::$app->user->id;
                $modelLike->work_id = Yii::$app->request->post('work_id');
                $modelLike->save();
            } elseif (Yii::$app->request->post('type') == 'delete') {
                if (Like::findOne(['work_id' => Yii::$app->request->post('work_id'), 'user_id' => Yii::$app->user->id])) {
                    Like::findOne(['work_id' => Yii::$app->request->post('work_id'), 'user_id' => Yii::$app->user->id])->delete();
                }
            }
        }

        if ($this->request->isPost) {
            // VarDumper::dump(WorkCollection::findOne(['id' => Yii::$app->request->post('collection_id')]), 100, true);
            //         die;
            if (Yii::$app->request->post('type') == 'delete-collection') {
                if (WorkCollection::findOne(['id' => Yii::$app->request->post('collection_id')])) {
                    WorkCollection::findOne(['id' => Yii::$app->request->post('collection_id')])->delete();
                }
            }
        }

        $modelCollection = new WorkCollection();
        $modelComment = new Comment();
        if ($this->request->isPost) {

            if ($this->request->post('WorkCollection')) {
                $modelCollection->load($this->request->post());

                // VarDumper::dump($modelCollection->collections_array, 100, true);
                //     die;
                if ($modelCollection->collections_array) {
                    // VarDumper::dump(!WorkCollection::find()->where(['collection_id' => $modelCollection->collections_array, 'work_id' => $id])->exists(), 100, true);
                    // die;
                    if (!WorkCollection::find()->where(['collection_id' => $modelCollection->collections_array, 'work_id' => $id])->exists()) {

                        $modelCollection->collection_id = $modelCollection->collections_array;
                        $modelCollection->work_id = $id;
                        $modelCollection->save(false);
                    }

                }
            }
        }
        if ($this->request->isPost) {
            if ($this->request->post('content') != null) {

                if ($modelComment) {

                    $modelComment->content = Yii::$app->request->post('content');
                    $modelComment->user_id = Yii::$app->user->id;
                    $modelComment->work_id = $id;
                    $modelComment->save(false);
                }
            }
        }


        $dataProviderCategories = new ActiveDataProvider([
            'query' => Category::find()->select('category.*')->innerJoin('work_category', 'work_category.category_id=category.id AND work_category.work_id=' . $id),

        ]);

        $dataProviderLike = new ActiveDataProvider([
            'query' => Work::find()
                ->select('work.*')
                ->innerJoin('work_category', 'work_category.work_id=work.id')->limit(6)
                ->andFilterWhere([
                    'category_id' => WorkCategory::find()
                        ->select('category_id')
                        ->where(['work_id' => $id])
                        ->groupBy('work.id')
                ])
        ]);
        // var_dump($dataProviderLike);
        // die;

        $dataProviderAuthor = new ActiveDataProvider([
            'query' => Work::find()->where(['user_id' => $model->user_id])->orderBy(new Expression('rand()'))->limit(6)
        ]);
        $dataProviderComments = new ActiveDataProvider([
            'query' => Comment::find()->where(['work_id' => $model->id]),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        return $this->render('view', [
            'model' => $model,
            'dataProviderAuthor' => $dataProviderAuthor,
            'dataProviderComments' => $dataProviderComments,
            'dataProviderCategories' => $dataProviderCategories,
            'dataProviderLike' => $dataProviderLike,
            'modelComment' => $modelComment,
            'modelCollection' => $modelCollection,

        ]);
    }

    /**
     * Creates a new Work model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Work();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                if ($model->save(false)) {
                    foreach ($model->categories_array as $key => $category) {
                        $modelCategory = new WorkCategory();
                        $modelCategory->category_id = Category::findOne(['title' => $category])->id;
                        $modelCategory->work_id = $model->id;
                        $modelCategory->save();
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Work model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->categories_array = WorkCategory::find()->select('category_id')->where(['work_id' => $model->id])->column();
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->scenario = Work::SCENARIO_UPDATE;
            $model->save();
            WorkCategory::deleteAll(['work_id' => $model->id]);
            foreach ($model->categories_array as $key => $category) {
                $modelCategory = new WorkCategory();
                $modelCategory->category_id = Category::findOne(['title' => $category])->id;
                $modelCategory->work_id = $model->id;
                $modelCategory->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Work model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['cabinet/index']);
    }

    /**
     * Finds the Work model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Work the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Work::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
