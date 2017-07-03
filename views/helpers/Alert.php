<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\views\helpers;

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
}
