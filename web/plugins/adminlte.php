<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*****************************************
 * CSS
 *****************************************/

$this->registerCssFile("@web/plugins/adminlte/dist/css/AdminLTE.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    'media' => 'all',
], 'adminlte-style-file');

$this->registerCssFile("@web/plugins/adminlte/dist/css/skins/_all-skins.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    'media' => 'all',
], 'adminlte-skin-styles');

//$this->registerCssFile("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css", [
//    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
//    'media' => 'all',
//], 'bootstrap');


/*****************************************
 * JS
 *****************************************/

$this->registerJsFile(
    '@web/js/jquery-ui.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

//$this->registerJsFile(
//    '@web/plugins/adminlte/bootstrap/js/bootstrap.min.js',
//    ['depends' => [\yii\web\JqueryAsset::className()]]
//);

$this->registerJsFile(
    'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/plugins/adminlte/dist/js/app.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);