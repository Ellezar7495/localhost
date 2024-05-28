<?php

namespace app\controllers;

use app\models\Like;
use app\models\Search;
use app\models\Subscribe;
use app\models\User;
use app\models\Work;
use app\models\WorkSearch;
use yii\bootstrap5\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;
use yii\web\UploadedFile;

class CabinetController extends \yii\web\Controller

{
    public function actions()
    {
        if(Yii::$app->user->isGuest) {
            $this->goHome();
        }
    }
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
        $searchModelWork = new Search();
        $dataProvider = $searchModelWork->search($this->request->queryParams, 'UserWork');

        return $this->render('index', [
            'searchModel' => $searchModelWork,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCollections()
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
        $searchModelWork = new Search();
        $dataProvider = $searchModelWork->search($this->request->queryParams, 'Collection');

        return $this->render('collections', [
            'searchModel' => $searchModelWork,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionProfile()
    {
        $model = $this->findUser(Yii::$app->user->identity->id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load($this->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->scenario = User::SCENARIO_CREATE_PROFILE_IMAGE;
            if ($model->imageFile != null) {
                $model->imageFile->saveAs('@app/web/uploads/' . $model->imageFile->baseName . '.' . $model->imageFile->extension);
                $model->img_url = $model->imageFile->baseName . '.' . $model->imageFile->extension;
                $model->save(false);
            }
            return $this->refresh();

        }
        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Work model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Work::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionAuthor($id)
    {
        $model = $this->findUser($id);
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
        $dataProvider = new ActiveDataProvider([
            'query' => Work::find()->where(['user_id' => $id])
        ]);

        return $this->render('author', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            
        ]);

    }
    public function actionSubscribe($id, $url)
    {
        $model = new Subscribe();
        $model->user_id = Yii::$app->user->id;
        $model->author_id = $id;
        $model->save(false);

        return $this->redirect($url);

    }
    public function actionLiked()
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

        $dataProvider = new ActiveDataProvider([
            'query' => Work::find()->select('work.*')->innerJoin('like', 'like.work_id=work.id AND like.user_id=' . Yii::$app->user->id)
        ]);

        return $this->render('liked', [

            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDeleteSubscribe($id, $url)
    {
        Subscribe::findOne(['author_id' => $id, 'user_id' => Yii::$app->user->id])->delete();
        return $this->redirect($url);
    }
    protected function findUser($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
