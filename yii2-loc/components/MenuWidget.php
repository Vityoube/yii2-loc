<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuWidget
 *
 * @author vkalashnykov
 */
namespace app\components;

use yii\base\Widget;


class MenuWidget extends Widget{
    
    public $tpl;
    //put your code here
    public $data;
    public $tree;
    public $menuHtml;
    
    public function run(){
        return $this->tpl;
    }
    
    public function init() {
        parent::init();
        if ($this->tpl===null){
            $this->tpl='menu';
        }        
        $this->tpl.='.php';
    }
}
