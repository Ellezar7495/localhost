<?php

namespace app\controllers;

use app\models\Search;
use app\models\User;
use app\models\Work;
use app\models\WorkSearch;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\UploadedFile;

class CabinetController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModelWork = new Search();
        $dataProvider = $searchModelWork->search($this->request->queryParams, 'UserWork');

        return $this->render('index', [
            'searchModel' => $searchModelWork,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCollections()
    {
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
    protected function findUser($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
