<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_category".
 *
 * @property int $id
 * @property int $category_id
 * @property int $work_id
 *
 * @property Category $category
 * @property Work $work
 */
class WorkCategory extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'work_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => 'Category ID',
            'work_id' => 'Work ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
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
