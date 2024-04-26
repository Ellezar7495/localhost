<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "like_collection".
 *
 * @property int $id
 * @property int $like_id
 * @property int $collection_id
 *
 * @property Collection $collection
 * @property Like $like
 */
class LikeCollection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'like_collection';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['like_id', 'collection_id'], 'required'],
            [['like_id', 'collection_id'], 'integer'],
            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collection::class, 'targetAttribute' => ['collection_id' => 'id']],
            [['like_id'], 'exist', 'skipOnError' => true, 'targetClass' => Like::class, 'targetAttribute' => ['like_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'like_id' => 'Like ID',
            'collection_id' => 'Collection ID',
        ];
    }

    /**
     * Gets query for [[Collection]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasOne(Collection::class, ['id' => 'collection_id']);
    }

    /**
     * Gets query for [[Like]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLike()
    {
        return $this->hasOne(Like::class, ['id' => 'like_id']);
    }
}
