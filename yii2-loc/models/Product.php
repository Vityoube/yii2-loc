<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Description of Product
 *
 * @author vkalashnykov
 */
class Product extends ActiveRecord{
    
    public static function tableName() {
        return 'product';
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
}
