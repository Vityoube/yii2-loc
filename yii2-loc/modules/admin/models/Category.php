<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $keywords
 * @property string $description
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'required'],
            [['name', 'keywords', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Category No',
            'parent_id' => 'Parent category',
            'name' => 'Name',
            'keywords' => 'Keywords',
            'description' => 'Description',
        ];
    }
    
    public function getCategory(){
        return $this->hasOne(Category::className(), ['id'=>'parent_id']);
    }
}
