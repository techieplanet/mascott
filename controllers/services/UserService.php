<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\services;

use Yii;

/**
 * Description of UserService
 *
 * @author Swedge
 */
class UserService {
    //put your code here
    public  function createSalt(){
        return Yii::$app->getSecurity()->generateRandomString(6);
    }
    
    //put your code here
    public  function createPassword(){
        return Yii::$app->getSecurity()->generateRandomString(6);
    }
}
