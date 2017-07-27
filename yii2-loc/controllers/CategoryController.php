<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;
/**
 * Description of CategoryController
 *
 * @author vkalashnykov
 */
class CategoryController extends AppController{
    
    public function actionIndex(){
        $hits= Product::find()->where(['hit'=>'1'])->limit(6)->all();
        $this->setMeta('E_SHOPPER');
        return $this->render('index', compact('hits'));
    }
    
   public function actionView($id){
       $id= Yii::$app->request->get('id');
       $products= Product::find()->where(['category_id'=>$id])->all();
       $category= Category::findOne($id);
       $this->setMeta('E_SHOPPER | '.$category->name,$category->keywords,$category->description);
       return $this->render('view', compact('products','category'));
   }
}
