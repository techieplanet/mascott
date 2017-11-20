<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of BaseModel
 *
 * @author swedge-mac
 */
class BaseModel extends \yii\db\ActiveRecord {
    //put your code here
    /**
     * This method helps to change the numeric keys of the array to strings as needed.
     * This became necessary because we had to use createCommand() method of ActiveQuery.
     * CreateCommand was necessary because the asArray when used makes some correct query results data 
     * give errors when being converted into arrays.
     * 
     * @param type $valuesArray
     * @param type $indexByKey
     * @return type
     */
    public function changeKeys($valuesArray, $indexByKey){
        $resultArray = [];
        foreach ($valuesArray as $valuesElm)
            $resultArray[$valuesElm[$indexByKey]] = $valuesElm;
        
        ksort($resultArray);
        
        return $resultArray;
    }
}
