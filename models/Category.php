<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 *
 * @property WorkCategory[] $workCategories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * Gets query for [[WorkCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkCategories()
    {
        return $this->hasMany(WorkCategory::class, ['category_id' => 'id']);
    }
    public static function getCategories()
    {
        return self::find()->select('title')->indexBy('title')->column();
    }
}
