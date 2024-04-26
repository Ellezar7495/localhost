<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "like_work".
 *
 * @property int $id
 * @property int $like_id
 * @property int $work_id
 *
 * @property Like $like
 * @property Work $work
 */
class LikeWork extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'like_work';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['like_id', 'work_id'], 'required'],
            [['like_id', 'work_id'], 'integer'],
            [['like_id'], 'exist', 'skipOnError' => true, 'targetClass' => Like::class, 'targetAttribute' => ['like_id' => 'id']],
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
            'like_id' => 'Like ID',
            'work_id' => 'Work ID',
        ];
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
