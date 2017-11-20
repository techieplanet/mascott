<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\views\helpers;

use yii\helpers\Html;

/**
 * Description of Alerts
 *
 * @author Swedge
 */
class Alert {
    //put your code here
    public static function showSuccess($msg=''){
        if($msg === '')
            $msg = 'Successful';
        
        return '<div class=" no-print">
          <div class="callout callout-success margintop10 marginbottom10">
            <i class="glyphicon glyphicon-ok" aria-hidden="true"></i> ' .
            $msg .
          '</div>
        </div>';
    }
    
    public static function showError($msg=''){
        if($msg === '')
            $msg = 'Error occurred!';
        
        return '<div class=" no-print">
          <div class="callout callout-danger margintop10 marginbottom10">
            <i class="glyphicon glyphicon-ban-circle" aria-hidden="true"></i> ' .
            $msg .
          '</div>
        </div>';
    }
    
    public static function showButton($text, $buttonType=''){
        $buttonType = !empty($buttonType) ? 'btn-' . $buttonType : '';
        return '<button class="btn btn-sm '.$buttonType.'">'.$text . '</button>';
    }
}
