<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */
/* @var $ */

?>

<p>
    Dear <?= $firstname . ' ' . $lastname ?>,<br/><br/>
 
    You have successfully registered for NAFDAC MAS Reporting system.<br/>
    You may now login with your username and password by clicking the button below.
    <br/><br/>
    
    <strong>Login Details</strong><br/>
    Email: <?= $email ?><br/>
    Password: <?= $password ?><br/><br/>
</p>

<p style="text-align: center;">
    <?= Html::a('Log In', Url::home('http'), [
            'style' => [
                'border-radius' => '3px',
                '-webkit-box-shadow' => 'none',
                'box-shadow' => 'none',
                'border' => '1px solid transparent',
                'display' => 'inline-block',
                'padding' => '8px 15px',
                'margin-bottom' => '0',
                'font-size' => '20px',
                'font-weight' => 'normal',
                'line-height' => '1.42857143',
                'text-align' => 'center',
                'white-space' => 'nowrap',
                'vertical-align' => 'middle',
                '-ms-touch-action' => 'manipulation',
                'touch-action' => 'manipulation',
                'cursor' => 'pointer',
                '-webkit-user-select' => 'none',
                '-moz-user-select' => 'none',
                '-ms-user-select' => 'none',
                'user-select' => 'none',
                'background-image' => 'none',
                'border-color' => '#008d4c',
                'background-color' => '#2F9E69 !important',
                'border' => '1px solid transparent',
                'border-radius' => '4px',
                'color' => '#FFFFFF',
                'text-decoration' => 'none'
            ]
        ]) ?>
</p>

<br/>
<p>
    
    If the button does not work, please copy the link below, paste in your browser address bar and hit Enter key.<br/>
    <?= Html::a(Url::home('http'), Url::home('http')) ?>
</p>