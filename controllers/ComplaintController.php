<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Complaint;
use app\models\UsageReport;
use app\models\utils\Trailable;

/**
 * ComplaintController implements the CRUD actions for Complaint model.
 */
class ComplaintController extends Controller
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
     * Lists all Complaint models.
     * @return mixed
     */
    public function actionIndex()
    {
        $fakeReports = UsageReport::getFalseReports();
        $model = new Complaint();
        
        return $this->render('index', [
            'fakeReports' => $fakeReports,
            'model' => $model
        ]);
    }

    /**
     * Displays a single Complaint model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    
    /**
     * This method will be used to handle the post req
     */
    public function actionHandle()
    {    
        $reportId = $_POST['Complaint']['report_id'];
        $complaint = UsageReport::findOne($reportId)->complaint;
        
        if(is_object($complaint))
            $this->update($complaint->id);
        else
            $this->create();
        
    }

    /**
     * Creates a new Complaint model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function create()
    {
        $model = new Complaint();
        (new Trailable($model))->registerInsert();
                
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('saved', 'CREATED');
        } else {
            $model->addError('validation_result', 'Could not save. Ensure to select a verification result');
            Yii::$app->session->setFlash('error', $model->getErrors());
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Updates an existing Complaint model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function update($id)
    {
        $model = $this->findModel($id);
        (new Trailable($model))->registerUpdate();
                
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('saved', 'UPDATED');
        } else {
            $model->addError('validation_result', 'Could not update. Ensure to select a verification result');
            Yii::$app->session->setFlash('error', $model->getErrors());
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Complaint model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Complaint model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Complaint the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Complaint::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
