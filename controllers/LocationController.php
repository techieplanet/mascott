<?php

namespace app\controllers;

use Yii;
use app\models\Batch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Location;

/**
 * BatchController implements the CRUD actions for Batch model.
 */
class LocationController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionSetUpLocations(){
        Location::setUp();
    }
    
}
