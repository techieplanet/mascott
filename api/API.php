<?php

namespace app\api;

/**
 * api module definition class
 */
class API extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\api\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        \Yii::$app->user->enableSession = false;
        \Yii::$app->user->loginUrl = null;
        //\Yii::configure($this, require(__DIR__ . '/config.php'));
    }
}
