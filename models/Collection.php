<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "collection".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 *
 * @property User $user
 * @property WorkCollection[] $workCollections
 */
class Collection extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title'], 'required'],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[LikeCollections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikeCollections()
    {
        return $this->hasMany(LikeCollection::class, ['collection_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[WorkCollections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkCollections()
    {
        return $this->hasMany(WorkCollection::class, ['collection_id' => 'id']);
    }
    public static function getCollections()
    {
        return self::find()->select('title')->where(['user_id' => Yii::$app->user->id])->indexBy('id')->column();
    }
}
