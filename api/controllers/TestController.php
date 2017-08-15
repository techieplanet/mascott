<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\controllers;

use yii\web\Controller;

/**
 * Description of TestController
 *
 * @author Swedge
 */
class TestController extends Controller  {
    //put your code here
    public function actionIndex(){
        echo 'Inside Index';
    }
    
    public function actionGreet($name){
        echo 'Hello ' . $name;
    }
}
