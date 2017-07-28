<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\models\UsageReport;
use app\models\service\UsageReportService;
use app\models\Location;
use app\models\Product;
use app\controllers\services\LocationService;
use app\controllers\services\ProviderService;
use app\controllers\services\ProductTypeService;
use app\controllers\services\ProductService;


/**
 * Description of CounterfeitsController
 *
 * @author Swedge
 */
class CounterfeitController extends BaseController {
    //put your code here
    
    public function actionFakeResponses(){
        $filtersArray = array();
//        $filtersArray = array(
//            'product_type' => 0, 
//            'providers' => json_encode([]), 
//            'geozones' => json_encode([]), 
//            'states' => json_encode([]), 
//            'lgas' => json_encode([])
//        );
        
        $reportService = new UsageReportService();
        
        $ptService = new ProductTypeService();
        $providerService = new ProviderService();
        $locationService = new LocationService();
       
        $ptMap = $ptService->getProductTypesMap(); $ptMap[0] = '--Select Product Type--'; ksort($ptMap);
        $providerMap = $providerService->getProviderMap(); /*$providerMap[0] = '--Select Provider--';*/ ksort($providerMap);
        
        if($post = Yii::$app->request->post()){
            Yii::$app->response->format = Response::FORMAT_JSON;     
            $filteredReports = $reportService->percentageFakeResponses($post, true);
            ksort($filteredReports);
            return $filteredReports;
        }
        
        $filteredReports = $reportService->percentageFakeResponses($filtersArray, true);
        ksort($filteredReports);
        
        return $this->render('fake-responses', [
            'product' => new Product(),
            'model' => new UsageReport(),
            'location' => new Location(),
            'ptMap' => $ptMap,
            'providerMap' => json_encode($providerMap),
            'lh' => $locationService->getLocationsHierachyAsJson(),
            'usageData' => json_encode($filteredReports)
        ]);
    }
}
