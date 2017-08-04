<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use app\models\Product;
use yii\web\HttpException;
/**
 * Description of ProductController
 *
 * @author vkalashnykov
 */
class ProductController extends AppController{

    public function actionView($id){
//        $id= \Yii::$app->request->get('id');
        $product= Product::findOne($id);
       if (empty($product))
               throw new HttpException(404, 'No such product.');
//        $product= Product::find()->with('category')->where(['id'=>$id])->limit(1)->one();
        $hits= Product::find()->where(['hit'=>'1'])->limit(5)->all();
        $this->setMeta('E_SHOPPER | '.$product->name,$product->keywords,$product->description);
        return $this->render('view',compact('product','hits'));
    }
    
}
