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
class UserService extends Service{
    
    public function sendNewUserEmail($model){
        $this->sendEmail(
                Yii::$app->params['no-reply-email'], //from 
                $model->email,                       //to
                'New Account Registration',         //$subject, 
                [
                    'password' => $model->tempPass,
                    'firstname' => $model->firstname,
                    'lastname' => $model->lastname,
                ],
                'new-user',                          //view/template file
                'new-account'                       //layout file
        );
    }
}
