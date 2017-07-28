<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * Description of BaseController
 *
 * @author Swedge
 */
class BaseController extends Controller {
    //put your code here
    
    public function beforeAction($action){
        if (Yii::$app->user->isGuest) {
            $this->redirect(['site/index?r='.$action->getUniqueId()]);
            return false;
        }
        
        return true;
    }
}
