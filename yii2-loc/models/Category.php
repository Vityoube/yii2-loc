<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Description of Category
 *
 * @author vkalashnykov
 */
class Category extends ActiveRecord{
    //put your code here
    
    public static function tableName() {
        return 'category';
    }
    
    public function getProducts(){
        return $this->hasMany(Product::className(), ['category_id'=>'id']);
    }
}
