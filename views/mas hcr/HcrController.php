<?php

namespace app\controllers;

use Yii;
use app\models\Hcr;

class HcrController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $hcr = new Hcr();

        if($hcr->load(Yii::$app->request->post())) {
            
            $hcr->created_by = 1;
            $hcr->created_date = date("Y-m-d : H:i:s");

            if($hcr->validate() && $hcr->save()) {
                Yii::$app->session->setFlash('success', 'New HCR Added');
            }
        }
        
        return $this->redirect(['index']);
    }

    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionIndex()
    {
        $hcr = Hcr::find()
                ->all();
        
        $hcrObj = new Hcr();
        
        if($hcr == null) {
            throw new \yii\web\NotFoundHttpException;
        }
        
        return $this->render('index', ['hcr'=>$hcr, 'hcrObj'=>$hcrObj]);
    }

    public function actionView()
    {
        return $this->render('view');
    }

}
