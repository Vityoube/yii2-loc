<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $content
 * @property double $price
 * @property string $keywords
 * @property string $description
 * @property string $img
 * @property string $hit
 * @property string $new
 * @property string $sale
 *
 * @property OrderItems[] $orderItems
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $image;
    public $gallery;
    
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name'], 'required'],
            [['category_id'], 'integer'],
            [['content', 'hit', 'new', 'sale'], 'string'],
            [['price'], 'number'],
            [['name', 'keywords', 'description', 'img'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'png, jpg'],
            [['gallery'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Product ID',
            'category_id' => 'Category',
            'name' => 'Name',
            'content' => 'Content',
            'price' => 'Price',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'image' => 'Photo',
            'gallery'=>'Gallery',
            'hit' => 'Hit',
            'new' => 'New',
            'sale' => 'Sale',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::className(), ['product_id' => 'id']);
    }
    
    public function getCategory(){
        return $this->hasOne(Category::className(), ['id'=>'category_id']);
    }
    
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }
    
    public function upload(){
        if ($this->validate()){
            $path='upload/store/'.$this->image->baseName.'.'.$this->image->extension;
            $this->image->saveAs($path);
            $this->attachImage($path,true);
            @unlink($path);
            return true;
        } else{
            return false;
        }
    }
    
    public function uploadGallery(){
        if ($this->validate()){
            foreach ($this->gallery as $file){
                $path='upload/store/'.$file->baseName.'.'.$file->extension;
                $file->saveAs($path);
                $this->attachImage($path,false);
                @unlink($path);
            }
            return true;
        } else{
            return false;
        }
    }
}
