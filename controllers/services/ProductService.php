<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\services;

use app\models\Product;
use yii\helpers\ArrayHelper;

/**
 * Description of ProductService
 *
 * @author Swedge
 */
class ProductService {
    //put your code here
    
    public function getProductMap(){
        return ArrayHelper::map(Product::getProductsAsAssocArray(), 'id', 'product_name');
    }
}
