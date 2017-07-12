<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
     
        
        //datatables
        'https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css',
        
        //admin LTE
        'plugins/adminlte/dist/css/AdminLTE.min.css',
        'plugins/adminlte/dist/css/skins/_all-skins.min.css',
        
        //font-awesome
        'plugins/font-awesome-4.7.0/css/font-awesome.min.css',
                
        //custom
	'css/custom.css',
    ];
    public $js = [         
        //jquery UI
        'js/jquery-ui.min.js',
        
        //adminlte bootstrap
        'plugins/adminlte/bootstrap/js/bootstrap.min.js',
        
        //app
        'plugins/adminlte/dist/js/app.min.js',
        
        //datatables
        'https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',
        'https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js',
        
        //Custom JS
        'js/custom.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
    ];
}
