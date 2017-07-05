<?php

namespace app\controllers;

use Yii;
use app\models\Product;
//use app\models\Role;
use app\controllers\services\HCRService;
use app\controllers\services\CountryService;
use app\controllers\services\ProviderService;
use app\controllers\services\ProductTypeService;
use app\models\utils\Trailable;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $success = false;
        $selectedHolderId = $selectedProviderId = $selectedCountryId = $selectedPTId = 0;
        $selectedMASCodeAssgn = $selectedMASCodeStatus = 0;
        $hcrService = new HCRService();
        $countryService = new CountryService();
        $providerService = new ProviderService();
        $ptService = new ProductTypeService();

        $hcrMap = $hcrService->getHCRMap(); $hcrMap[0] = '--Select HCR--'; ksort($hcrMap);
        $countryMap = $countryService->getCountryMap(); $countryMap[0] = '--Select Country--'; ksort($countryMap);
        $providerMap = $providerService->getProviderMap(); $providerMap[0] = '--Select Provider--'; ksort($providerMap);
        $ptMap = $ptService->getProductTypesMap(); $ptMap[0] = '--Select Product Type--'; ksort($ptMap);
            
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['update', 'id' => $model->id]);
            $success = true;
            $selectedHolderId = $model->certificate_holder;
            $selectedProviderId = $model->provider_id;
            $selectedCountryId = $model->production_country;
            $selectedPTId = $model->product_type;
            $selectedMASCodeAssgn = $model->mas_code_assigned;
            $selectedMASCodeStatus = $model->mas_code_status;
        }
                
        return $this->render('create', [
            'model' => $model,
            'success' => $success,
            'hcrMap' => $hcrMap,
            'countryMap' => $countryMap,
            'providerMap' => $providerMap,
            'ptMap' => $ptMap,
            'selectedHolderId' => $selectedHolderId,
            'selectedProviderId' => $selectedProviderId,
            'selectedCountryId' => $selectedCountryId,
            'selectedPTId' => $selectedPTId,
            'selectedMASCodeAssgn' => $selectedMASCodeAssgn,
            'selectedMASCodeStatus' => $selectedMASCodeStatus
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $success = false;
        $selectedHolderId = $selectedProviderId = $selectedCountryId = $selectedPTId = 0;
        $selectedMASCodeAssgn = $selectedMASCodeStatus = 0;
        $hcrService = new HCRService();
        $countryService = new CountryService();
        $providerService = new ProviderService();
        $ptService = new ProductTypeService();

        $hcrMap = $hcrService->getHCRMap(); $hcrMap[0] = '--Select HCR--'; ksort($hcrMap);
        $countryMap = $countryService->getCountryMap(); $countryMap[0] = '--Select Country--'; ksort($countryMap);
        $providerMap = $providerService->getProviderMap(); $providerMap[0] = '--Select Provider--'; ksort($providerMap);
        $ptMap = $ptService->getProductTypesMap(); $ptMap[0] = '--Select Product Type--'; ksort($ptMap);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            $success = true;
            $selectedHolderId = $model->certificate_holder;
            $selectedProviderId = $model->provider_id;
            $selectedCountryId = $model->production_country;
            $selectedPTId = $model->product_type;
            $selectedMASCodeAssgn = $model->mas_code_assigned;
            $selectedMASCodeStatus = $model->mas_code_status;
        }
        
        return $this->render('update', [
            'model' => $model,
            'success' => $success,
            'hcrMap' => $hcrMap,
            'countryMap' => $countryMap,
            'providerMap' => $providerMap,
            'ptMap' => $ptMap,
            'selectedHolderId' => $selectedHolderId,
            'selectedProviderId' => $selectedProviderId,
            'selectedCountryId' => $selectedCountryId,
            'selectedPTId' => $selectedPTId,
            'selectedMASCodeAssgn' => $selectedMASCodeAssgn,
            'selectedMASCodeStatus' => $selectedMASCodeStatus
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
