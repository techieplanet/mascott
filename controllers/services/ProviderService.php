<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\services;

use app\models\Provider;
use yii\helpers\ArrayHelper;

/**
 * Description of ProviderService
 *
 * @author Swedge
 */
class ProviderService {
    //put your code here
      /**
     * This method constructs a map of ID and nicename 
     * @return array(id=>x, title=>y)
     */
    public function getProviderMap(){
        return ArrayHelper::map(Provider::getProvidersAsAssocArray(), 'id', 'provider_name');
    }
}
