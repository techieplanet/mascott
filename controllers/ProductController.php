<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Product;
use app\models\Location;
use app\models\utils\Trailable;
use app\controllers\services\HCRService;
use app\controllers\services\CountryService;
use app\controllers\services\ProviderService;
use app\controllers\services\ProductTypeService;
use app\controllers\services\ProductService;
use app\controllers\services\LocationService;


/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $products = Product::find()->all();

        return $this->render('index', [
            'products' => $products,
        ]);
    }

    public function actionReport2(){
        echo 'report2'; exit;
    }
    
    public function actionReport()
    {
        $products = Product::find()->all();
        $model = new Product();
        $hcrService = new HCRService();
        $countryService = new CountryService();
        $providerService = new ProviderService();
        $ptService = new ProductTypeService();
        $productService = new ProductService();
        $locationService = new LocationService();
        
        $hcrMap = $hcrService->getHCRMap(); $hcrMap[0] = '--Select HCR--'; ksort($hcrMap);
        $countryMap = $countryService->getCountryMap(); $countryMap[0] = '--Select Country--'; ksort($countryMap);
        $providerMap = $providerService->getProviderMap(); $providerMap[0] = '--Select Provider--'; ksort($providerMap);
        $ptMap = $ptService->getProductTypesMap(); $ptMap[0] = '--Select Product Type--'; ksort($ptMap);
        $productMap = $productService->getProductMap(); $productMap[0] = '--Select Product--'; ksort($productMap);
        $locationsHieJson = $locationService->getLocationsHierachyAsJson();
        
        if ($model->load(Yii::$app->request->post())) {
            $filtersArray = $model->attributes;
            //echo json_encode($filtersArray); exit;
            $reportArray = $model->getProductReport($filtersArray);
            echo json_encode($reportArray);
            exit;
        }
        
        return $this->render('report', [
            'products' => $products,
            'model' => $model,
            'hcrMap' => $hcrMap,
            'countryMap' => $countryMap,
            'providerMap' => $providerMap,
            'ptMap' => $ptMap,
            'productMap' => $productMap,
            'lh'=> $locationsHieJson
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $hcrService = new HCRService();
        $countryService = new CountryService();
        $providerService = new ProviderService();
        $ptService = new ProductTypeService();

        $hcrMap = $hcrService->getHCRMap(); $hcrMap[0] = '--Select HCR--'; ksort($hcrMap);
        $countryMap = $countryService->getCountryMap(); $countryMap[0] = '--Select Country--'; ksort($countryMap);
        $providerMap = $providerService->getProviderMap(); $providerMap[0] = '--Select Provider--'; ksort($providerMap);
        $ptMap = $ptService->getProductTypesMap(); $ptMap[0] = '--Select Product Type--'; ksort($ptMap);
        
        if ($model->load(Yii::$app->request->post())) {
            (new Trailable($model))->registerInsert();
            if ($model->save()) {
                Yii::$app->session->setFlash('saved', 'CREATED');
                return $this->redirect(['update', 'id' => $model->id, 'new' => true]);                
            }
        }
                
        return $this->render('create', [
            'model' => $model,
            'hcrMap' => $hcrMap,
            'countryMap' => $countryMap,
            'providerMap' => $providerMap,
            'ptMap' => $ptMap
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $new = false)
    {
        $model = $this->findModel($id);
        $hcrService = new HCRService();
        $countryService = new CountryService();
        $providerService = new ProviderService();
        $ptService = new ProductTypeService();

        $hcrMap = $hcrService->getHCRMap(); $hcrMap[0] = '--Select HCR--'; ksort($hcrMap);
        $countryMap = $countryService->getCountryMap(); $countryMap[0] = '--Select Country--'; ksort($countryMap);
        $providerMap = $providerService->getProviderMap(); $providerMap[0] = '--Select Provider--'; ksort($providerMap);
        $ptMap = $ptService->getProductTypesMap(); $ptMap[0] = '--Select Product Type--'; ksort($ptMap);

        $new == true ?  Yii::$app->session->setFlash('saved', Yii::$app->session->getFlash('saved')) : '';
            
        if ($model->load(Yii::$app->request->post())) {
            (new Trailable($model))->registerUpdate();
            if($model->save()) {
                Yii::$app->session->setFlash('saved', 'UPDATED');
            }
        }
        
        return $this->render('update', [
            'model' => $model,
            'hcrMap' => $hcrMap,
            'countryMap' => $countryMap,
            'providerMap' => $providerMap,
            'ptMap' => $ptMap
        ]);
        
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
