<?php

namespace app\api\controllers;

use yii\web\Controller;

/**
 * Default controller for the `api` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    { 
        throw new \yii\web\NotFoundHttpException('Page not found');
    }
}
