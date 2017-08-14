<?php

namespace app\controllers;

use Yii;
use app\models\HCR;
use app\models\utils\Trailable;


class HcrController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $hcr = new HCR();

        if($hcr->load(Yii::$app->request->post())) {
            
            (new Trailable($hcr))->registerInsert();

            if($hcr->validate() && $hcr->save()) {
                Yii::$app->session->setFlash('saved', 'CREATED');
            }
        }
        
        return $this->redirect(['index']);
    }
    
    
    public function actionUpdate()
    {
        $id = isset($_POST['HCR']['id']) ? $_POST['HCR']['id'] : '';
        
        $hcr = $this->findModel($id);

        if($hcr->load(Yii::$app->request->post())) {
            
            (new Trailable($hcr))->registerUpdate();

            if($hcr->validate() && $hcr->save()) {
                Yii::$app->session->setFlash('saved', 'CREATED');
            }
        }
        
        return $this->redirect(['index']);
    }

    
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    

    public function actionIndex()
    {
        $hcr = HCR::find()
                ->all();
        
        $hcrObj = new HCR();
        
        if($hcr == null) {
            throw new \yii\web\NotFoundHttpException;
        }
        
        return $this->render('index', ['hcr'=>$hcr, 'hcrObj'=>$hcrObj]);
    }

    public function actionView()
    {
        return $this->render('view');
    }
    
    protected function findModel($id)
    {
        if (($model = \app\models\HCR::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
