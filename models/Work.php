<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work".
 *
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property int $user_id
 * @property string $created_at
 * @property string|null $img_url
 * 
 
 *
 * @property Comment[] $comments
 * @property LikeWork[] $likeWorks
 * @property WorkCategory[] $workCategories
 * @property WorkCollection[] $workCollections
 * @property string|null $categories_array
 * @property string|null $imageFile
 */
class Work extends \yii\db\ActiveRecord
{
    public $imageFile;
    public array $categories_array;
    const SCENARIO_UPDATE = 'scenarioUpdate';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['user_id'], 'integer'],
            [['categories_array'], 'required'],
            [['created_at'], 'safe'],
            [['title', 'content', 'img_url'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'mimeTypes'=> 'image/*', 'on' => self::SCENARIO_UPDATE,],
            [['img_url'], 'required', 'on' => self::SCENARIO_UPDATE]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'img_url' => 'Img Url',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['work_id' => 'id']);
    }

    /**
     * Gets query for [[LikeWorks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikeWorks()
    {
        return $this->hasMany(LikeWork::class, ['work_id' => 'id']);
    }

    /**
     * Gets query for [[WorkCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkCategories()
    {
        return $this->hasMany(WorkCategory::class, ['work_id' => 'id']);
    }

    /**
     * Gets query for [[WorkCollections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkCollections()
    {
        return $this->hasMany(WorkCollection::class, ['work_id' => 'id']);
    }
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if($insert){
            $this->user_id = Yii::$app->user->id;
            $this->imageFile->saveAs('@app/web/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $this->img_url = $this->imageFile->baseName . '.' . $this->imageFile->extension;
        }
        return true;
    }
    public static function getAuthors($data) {
     
        return User::find()->select('user.*')->leftJoin('work', 'work.user_id=id');
    }
    public function upload()
    {
            $this->imageFile->saveAs('@app/web/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $this->img_url = $this->imageFile->baseName . '.' . $this->imageFile->extension;
            return true;
    }
}
