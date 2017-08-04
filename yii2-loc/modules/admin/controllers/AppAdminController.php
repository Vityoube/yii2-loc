<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
/**
 * Description of AppAdminController
 *
 * @author vkalashnykov
 */
class AppAdminController extends Controller{
    //put your code here
    public function behaviors() {
        return [
          'access' => [
              'class'=> AccessControl::className(),
              'rules'=> [
                  [
                    'allow'=>true,
                    'roles'=>['@']
                  ]    
              ]
          ]  
        ];
    }
}
