<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UsageReport;
use app\models\Location;
use app\controllers\services\LocationService;
use app\models\utils\Trailable;

/**
 * UsageReportController implements the CRUD actions for UsageReport model.
 */
class UsageReportController extends Controller
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
     * Lists all UsageReport models.
     * @return mixed
     */
    public function actionIndex()
    {        
        $reports = UsageReport::find()->all();

        return $this->render('index', [
            'reports' => $reports,
        ]);
    }

    /**
     * Displays a single UsageReport model.
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
     * Creates a new UsageReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UsageReport();
        $locationService = new LocationService();
        $locationsHieJson = $locationService->getLocationsHierachyAsJson();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->location_id = $locationService->getSelectedLocationId(
                    $_POST['UsageReport']['geozone_id'],
                    $_POST['UsageReport']['state_id'],
                    $_POST['UsageReport']['lga_id']
            );
            (new Trailable($model))->registerInsert(); //audit trail
            if($model->save()){
                Yii::$app->session->setFlash('saved', 'CREATED');
                return $this->redirect(['update', 'id' => $model->id, 'new' => true]);
            }
        } 
        
        return $this->render('create', [
                'model' => $model,
                'lh' => $locationsHieJson,
                'parentsJson' => '0'
        ]);
        
    }

    /**
     * Updates an existing UsageReport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id, $new = false)
    {
        $model = $this->findModel($id);
        $locationService = new LocationService();
        $locationsHieJson = $locationService->getLocationsHierachyAsJson();
        
        $new == true ?  Yii::$app->session->setFlash('saved', Yii::$app->session->getFlash('saved')) : '';
        
        if ($model->load(Yii::$app->request->post())) {
            $model->location_id = $locationService->getSelectedLocationId(
                    $_POST['UsageReport']['geozone_id'],
                    $_POST['UsageReport']['state_id'],
                    $_POST['UsageReport']['lga_id']
            );
            (new Trailable($model))->registerUpdate(); //audit trail
            if ($model->save()) {
                Yii::$app->session->setFlash('saved', 'UPDATED');
            }
        } 
        
        //get parents array
        $parentsJson = $locationService->traceSelectedLocationParents($model->location_id);
        return $this->render('update', [
            'model' => $model,
            'lh' => $locationsHieJson,
            'parentsJson' => $parentsJson
        ]);
        
    }

    /**
     * Deletes an existing UsageReport model.
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
     * Finds the UsageReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UsageReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsageReport::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
