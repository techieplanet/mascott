<?php

namespace app\controllers;

use Yii;
use app\models\Provider;
use app\models\utils\Trailable;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProviderController implements the CRUD actions for Provider model.
 */
class ProviderController extends BaseController
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
     * Lists all Provider models.
     * @return mixed
     */
    public function actionIndex()
    {
        $providers = Provider::find()->all();

        return $this->render('index', [
            'providers' => $providers,
        ]);
    }

    /**
     * Displays a single Provider model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Provider model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Provider();
        
        if($model->load(Yii::$app->request->post())){
            (new Trailable($model))->registerInsert(); //audit trail
            if ($model->save()) {    
                Yii::$app->session->setFlash('saved', 'CREATED');
                return $this->redirect(['update', 'id' => $model->id, 'new' => true]);
            }
        } 
        
        return $this->render('create', [
                'model' => $model,
        ]);
        
        
    }

    /**
     * Updates an existing Provider model.
     * @param integer $id
     * @param boolean $new
     * @return mixed
     */
    public function actionUpdate($id, $new = false)
    {
        $model = $this->findModel($id);
        $new == true ?  Yii::$app->session->setFlash('saved', Yii::$app->session->getFlash('saved')) : '';
        
        if ($model->load(Yii::$app->request->post())) {
            (new Trailable($model))->registerUpdate(); //audit trail
            if ($model->save()) {
                Yii::$app->session->setFlash('saved', 'UPDATED');
            }
        }
        
        return $this->render('update', [
                'model' => $model,
        ]);   
    }

    /**
     * Deletes an existing Provider model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Provider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Provider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Provider::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
