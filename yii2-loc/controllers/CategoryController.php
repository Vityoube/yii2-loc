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
use yii\data\Pagination;
use yii\web\HttpException;
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
//       $id= Yii::$app->request->get('id');
       $category= Category::findOne($id);
       if (empty($category))
               throw new HttpException(404, 'No such category.');
//       $products= Product::find()->where(['category_id'=>$id])->all();
       $query= Product::find()->where(['category_id'=>$id]);
       $pages=new Pagination(['totalCount'=>$query->count(),'pageSize'=>3,'forcePageParam'=>false,
           'pageSizeParam'=>false]);
       $products=$query->offset($pages->offset)->limit($pages->limit)->all();
       $this->setMeta('E_SHOPPER | '.$category->name,$category->keywords,$category->description);
       return $this->render('view', compact('products','pages','category'));
   }
   
   public function actionSearch(){
         $q= trim(Yii::$app->request->get('q'));
         $this->setMeta('E_SHOPPER | Search '.$q);
         if (!$q) 
             return $this->render('search', compact('q'));
         $query= Product::find()->where(['like','name',$q]);
         $pages=new Pagination(['totalCount'=>$query->count(),'pageSize'=>3,'forcePageParam'=>false,
           'pageSizeParam'=>false]);
         $products=$query->offset($pages->offset)->limit($pages->limit)->all();
         
         return $this->render('search', compact('products','pages','q'));
         
   }
}
