<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\services;

use app\models\ProductType;
use yii\helpers\ArrayHelper;

/**
 * Description of ProductTypeService
 *
 * @author Swedge
 */
class ProductTypeService {
    //put your code here
    
    /**
     * This method constructs a map of ID and Title 
     * @return array(id=>x, title=>y)
     */
    public function getProductTypesMap(){
        return ArrayHelper::map(ProductType::getProductTypesAsAssocArray(), 'id', 'title');
    }
}
