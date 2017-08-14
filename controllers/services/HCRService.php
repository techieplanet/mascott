<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\services;

use app\models\HCR;
use yii\helpers\ArrayHelper;
/**
 * Description of HCRService
 *
 * @author Swedge
 */
class HCRService extends Service {
    //put your code here
    /**
     * This method constructs a map of ID and Title 
     * @return array(id=>x, title=>y)
     */
    public function getHCRMap(){
        return ArrayHelper::map(HCR::getHCRAsAssocArray(), 'id', 'name');
    }
}
