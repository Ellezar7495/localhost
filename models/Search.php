<?php

namespace app\models;

use Symfony\Component\VarDumper\VarDumper;
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

        $collection = Work::find()->select('work.*')->innerJoin('work_collection', 'work_collection.work_id=work.id');


        $query = new Query();

        $author = Work::find()->where(['user_id' => $id]);
        $work = Work::find()->select('work.*')->innerJoin('work_category', 'work_category.work_id=work.id');
        $work_user = Work::find()->where(['user_id' => Yii::$app->user->id]);
        $user = User::find();
        $userLiked = Work::find()->select('work.*')->innerJoin('like', 'like.work_id=work.id AND like.user_id=' . Yii::$app->user->id);
        $category = Category::find();
        // SELECT * FROM `work`
        // LEFT JOIN `like`
        // ON like.work_id=work.id and like.user_id=3

        // SELECT DISTINCT `login` FROM `user` LEFT JOIN `work` ON work.user_id=user.id LEFT JOIN `work_collection` ON work.id = work_collection.work_id WHERE work_collection.collection_id = 7;


        // Collection::find()->select();
        // if($this->searchCategory){
        //     VarDumper::dump($this->searchCategory, 10, true);
        // }


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
            $work->andFilterWhere(['work_category.category_id' => $this->searchCategory ? Category::findOne(['title' => $this->searchCategory])->id : ''])->andFilterWhere([
                'like',
                'title',
                $this->search
            ]);
            // var_dump($this->searchCategory);

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
                'like',
                'title',
                $this->search
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
        if ($type == 'UserLiked') {
            $userLiked->andFilterWhere([
                'like',
                'title',
                $this->search
            ]);
            $dataProvider = new ActiveDataProvider([
                'query' => $userLiked,
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
