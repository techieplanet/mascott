<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */
/* @var $ */

?>

<p>
    Dear <?= $firstname . ' ' . $lastname ?>,<br/>
    A new account has been created for you on the MAS platform. <br/><br/>
    
    Username is your email.<br/>
    Password: <?= $password ?><br/>
</p><br/>

Login here: <?= Html::a('Home page', Url::home('http')) ?><br/><br/><br/>