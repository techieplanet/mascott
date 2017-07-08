<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\utils;

use Yii;

/**
 * Description of Trailable
 *
 * @author Swedge
 * 
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 */
class Trailable {
    //put your code here
    public $model = null;
    
    function __construct($model){
        $this->model = $model;
    }
    
    private function setCreatedBy($userId){
        $this->model->created_by = $userId;
    }
      
    private  function setCreatedDate($date){
        $this->model->created_date = $date;
    }
    
    private function setModifiedBy($userId){
        $this->model->modified_by = $userId;
    }
    
    private  function setModifiedDate($date){
        $this->model->modified_date = $date;
    }
    
    public function registerInsert(){
        $this->setCreatedBy(Yii::$app->user->identity->id);
        $this->setCreatedDate(date('Y-m-d H:i:s'));
    }
    
    public function registerUpdate(){
        $this->setModifiedBy(Yii::$app->user->identity->id);
        $this->setModifiedDate(date('Y-m-d H:i:s'));
    }
}
