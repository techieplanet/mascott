<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\service;

/**
 * Description of ModelServiceHelper
 *
 * @author Swedge
 */
class ArrayBalancer {
    //put your code here
    private $shorterArray = array();
    private $longerArray = array();
    private $balancingKey = '';
    
    public function __construct($longerArray, $shorterArray) {
        $this->shorterArray = $shorterArray;
        $this->longerArray = $longerArray;
    }
    
    public function balance(){
        $newLongArray = array_filter($this->longerArray, array($this, 'createBalance'), ARRAY_FILTER_USE_KEY);
        return $newLongArray;
    }
    
    private function createBalance($key){
        return array_key_exists($key, $this->shorterArray);
    }
}
