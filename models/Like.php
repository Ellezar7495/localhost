<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "like".
 *
 * @property int $id
 * @property int $user_id
 *
 * @property LikeCollection[] $likeCollections
 * @property LikeWork[] $likeWorks
 * @property User $user
 */
class Like extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'like';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
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
        ];
    }

    /**
     * Gets query for [[LikeCollections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikeCollections()
    {
        return $this->hasMany(LikeCollection::class, ['like_id' => 'id']);
    }

    /**
     * Gets query for [[LikeWorks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikeWorks()
    {
        return $this->hasMany(LikeWork::class, ['like_id' => 'id']);
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
}
