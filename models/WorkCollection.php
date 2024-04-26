<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_collection".
 *
 * @property int $id
 * @property int $collection_id
 * @property int $work_id
 *
 * @property Collection $collection
 * @property Work $work
 */
class WorkCollection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work_collection';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['collection_id', 'work_id'], 'required'],
            [['collection_id', 'work_id'], 'integer'],
            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collection::class, 'targetAttribute' => ['collection_id' => 'id']],
            [['work_id'], 'exist', 'skipOnError' => true, 'targetClass' => Work::class, 'targetAttribute' => ['work_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'collection_id' => 'Collection ID',
            'work_id' => 'Work ID',
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
     * Gets query for [[Work]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWork()
    {
        return $this->hasOne(Work::class, ['id' => 'work_id']);
    }
}
