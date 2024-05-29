<?php

namespace app\controllers;

use app\models\Like;
use Yii;
use yii\bootstrap5\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Search;
use app\models\Work;
use app\models\WorkSearch;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if ($this->request->isPost) {

            if (Yii::$app->request->post('type') == 'create') {
                $model = new Like();
                $model->user_id = Yii::$app->user->id;
                $model->work_id = Yii::$app->request->post('work_id');
                $model->save();
            } elseif (Yii::$app->request->post('type') == 'delete') {
                if (Like::findOne(['work_id' => Yii::$app->request->post('work_id'), 'user_id' => Yii::$app->user->id])) {
                    Like::findOne(['work_id' => Yii::$app->request->post('work_id'), 'user_id' => Yii::$app->user->id])->delete();
                }
            }
        }
        $searchModel = new Search();
        // VarDumper::dump($this->request->isAjax, 10, true);

        $dataProviderWork = $searchModel->search($this->request->queryParams, 'Work');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProviderWork' => $dataProviderWork,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity?->role_id == 2) {
                $this->redirect('/admin');
            } else {
            return $this->goBack();
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionReg()
    {
        $model = new \app\models\User();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
                Yii::$app->user->login($model);
                $this->goHome();
            }
        }

        return $this->render('reg', [
            'model' => $model,
        ]);
    }
    protected function findModel($id)
    {
        if (($model = Work::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            $this->goHome();
        }
        ;
    }
}
