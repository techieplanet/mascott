<?php

namespace app\controllers;

use Yii;
use app\models\Batch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BatchController implements the CRUD actions for Batch model.
 */
class BatchController extends BaseController
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

    /**
     * Lists all Batch models.
     * @return mixed
     */
    public function actionIndex()
    {
        return;
        $dataProvider = new ActiveDataProvider([
            'query' => Batch::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Batch model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return;
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Creates a new Batch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->checkPermission('view_edit_form_a');
            
        //echo 'inside create action'; exit;
        $model = new Batch();
        //trail
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //echo attr
        } 
        
//        else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Updates an existing Batch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        //trail
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //echo attr
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Batch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        //echo response
    }

    /**
     * Finds the Batch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Batch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Batch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
