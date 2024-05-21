<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Work;
use yii\db\Query;


class Search extends Model
{
    public $search;
    public $searchCategory;
    public $searchCollection;
    public $searchAuthor;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['search'], 'string'],
            [['searchCategory', 'searchCollection', 'searchAuthor'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

    public function search($params, $type, ?string $id = null)
    {

        $collection = Work::find()->select('work.*')->leftJoin('work_collection', 'work_collection.work_id=work.id');


        $author = Work::find()->where(['user_id' => $id]);
        $work = Work::find()->select('work.*')->leftJoin('work_category', 'work_category.work_id=work.id');
        $work_user = Work::find()->where(['user_id' => Yii::$app->user->id]);
        $user = User::find();
        // SELECT DISTINCT `login` FROM `user` LEFT JOIN `work` ON work.user_id=user.id LEFT JOIN `work_collection` ON work.id = work_collection.work_id WHERE work_collection.collection_id = 7;


        // Collection::find()->select();

        $category = Category::find();
        $this->load($params);
        // add conditions that should always apply here
        if ($type == 'User') {
            $user->andFilterWhere([
                'login' => $this->search
            ]);

            $dataProvider = new ActiveDataProvider([
                'query' => $user,
            ]);
        }
        if ($type == 'UserWork') {
            $work_user->andFilterWhere([ 
                'like',
                'title',
                $this->search
            ]);

            $dataProvider = new ActiveDataProvider([
                'query' => $work_user,
            ]);
        }
        if ($type == 'Work') {
            $work->andFilterWhere([
                'like',
                'title',
                $this->search
            ])->andFilterWhere(['category_id' => $this->searchCategory])->groupBy('work.id');

            $dataProvider = new ActiveDataProvider([
                'query' => $work,
            ]);
        }
        if ($type == 'Collection') {
            $collection->andFilterWhere([
                'like',
                'title',
                $this->search
            ])->andFilterWhere(['collection_id' => $this->searchCollection])->groupBy('work.id');


            $dataProvider = new ActiveDataProvider([
                'query' => $collection,
            ]);
        }
        if ($type == 'Category') {
            $category->andFilterWhere([
                'title' => $this->search
            ]);

            $dataProvider = new ActiveDataProvider([
                'query' => $category,
            ]);
        }
        if ($type == 'Author') {
            $author->andFilterWhere([
                'like',
                'title',
                $this->search
            ]);
            $dataProvider = new ActiveDataProvider([
                'query' => $author,
            ]);
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
            if ($params != null) {
                return $dataProvider;
            }
        }
        

        // grid filtering conditions



        return $dataProvider;
    }



    // public function searchSql($params){
    //     $query = new Query();
    //     $row = $query->select('Collection.title, Category.title, Work.title, User.login')
    //                 ->from('Collection', 'Category', 'Work')
    //                 ->where(['Collection.title, Category.title, Work.title' => $params])
    //                  ->orWhere(['User.login' => $params])
    // }
}
