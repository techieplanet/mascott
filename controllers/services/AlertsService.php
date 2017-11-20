<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\services;

use Yii;
use yii\helpers\Url;

/**
 * Description of AlertManager
 *
 * @author Swedge
 */
class AlertsService extends Service {
    private $alertsSenderEmail = '';
    
    function __construct() {
        $this->alertsSenderEmail = Yii::$app->params['no-reply-email'];
    }

    public function sendNewUserEmail($model){
        $this->sendEmail(
                //$this->alertsSenderEmail, //from 
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
    
    public function sendResolutionRequestEmail($usersList, $report){
        foreach($usersList as $user){
            $this->sendEmail(
                    //$this->alertsSenderEmail, //from 
                    $user->email,                       //to
                    'Resolution Request',         //$subject, 
                    [
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                        'report' => $report,
                        'url' => Url::to(['usage-report/index'], true)
                    ],
                    'resolution_request',                          //view/template file
                    'html'                       //layout file
            );
        }
    }
    
    public function sendResolutionUpdateEmail($usersList, $report){
        foreach($usersList as $user){
            $this->sendEmail(
                    //$this->alertsSenderEmail, //from 
                    $user->email,                 //to
                    'Resolution Update',         //$subject, 
                    [
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                        'report' => $report,
                        'url' => Url::to(['complaint/index'], true)
                    ],
                    'resolution_update',                          //view/template file
                    'html'                       //layout file
            );
        }
    }
}
