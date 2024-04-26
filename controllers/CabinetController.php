<?php

namespace app\controllers;

use app\models\Search;
use app\models\Work;
use app\models\WorkSearch;
use yii\web\NotFoundHttpException;

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
}
