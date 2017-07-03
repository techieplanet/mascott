<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

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
    public $myTrailClass = null;
    
    function Trailable($myTrailClass){
        $this->myTrailClass = $myTrailClass;
    }
    
    private function setCreatedBy($userId){
        $this->myTrailClass->created_by = $userId;
    }
      
    private  function setCreatedDate($date){
        $this->myTrailClass->created_date = $date;
    }
    
    private function setModifiedBy($userId){
        $this->myTrailClass->modified_by = $userId;
    }
    
    private  function setModifiedDate($date){
        $this->myTrailClass->modified_date = $date;
    }
    
    public  function registerInsert($userId){
        $this->setCreatedBy($userId);
        $this->setCreatedDate(date('Y-m-d H:i:s'));
    }
    
    public  function registerUpdate($userId){
        $this->setModifiedBy($userId);
        $this->setModifiedDate(date('Y-m-d H:i:s'));
    }
}
