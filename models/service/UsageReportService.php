<?php

namespace app\models\service;

use Yii;

use app\models\UsageReport;
use app\models\Location;
use app\models\Provider;

class UsageReportService extends UsageReport {
    
    /**
     * Move to service class later
     */
    public function getUsageRequestsReceived($filtersArray, $asArray=true) {
        $whereArray = array(); $geozoneIds = array(); $location = new Location();
        list($locationIDArray, $tiervalue) = Location::getGeoLevelData(
                array_key_exists('geozones', $filtersArray) ? json_decode($filtersArray['geozones']) : [],
                array_key_exists('states',$filtersArray) ? json_decode($filtersArray['states']) : [],
                array_key_exists('lgas',$filtersArray) ? json_decode($filtersArray['lgas']) : []
        ); 
        
        if(array_key_exists('product_type', $filtersArray) && !empty($filtersArray['product_type'])) 
                $whereArray['product_type'] =  $filtersArray['product_type'];
        
        if(array_key_exists('provider_id', $filtersArray) && !empty($filtersArray['provider_id'])) 
                $whereArray['provider_id'] = $filtersArray['provider_id'];
        
        $fromDate = array_key_exists('from_date', $filtersArray) && !empty($filtersArray['from_date']) ? 
                $filtersArray['from_date'] : 
                $this->getEarliestReported()->date_reported;
        
        $toDate = array_key_exists('to_date', $filtersArray) && !empty($filtersArray['to_date']) ? 
                $filtersArray['to_date'] : 
                $this->getLastReported()->date_reported;
        
        $tierText = $location->getTierText($tiervalue);
        $tierFieldName = $location->getTierFieldName($tiervalue);
        
        return UsageReport::find()
                ->select(['COUNT(*) AS requests', $tierFieldName . ' AS location_name', 'batch.batch_number', 'location_id'])
                ->innerJoinWith(['batch', 'location', 'batch.product.productType', 'batch.product.provider'])
                ->where($whereArray)
                ->andWhere(['in', $tierText, $locationIDArray])
                ->andWhere(['between', 'date_reported', $fromDate, $toDate])
                ->groupBy([$tierFieldName,'batch.batch_number', 'location_id'])
                ->indexBy('location_name')
                ->asArray($asArray)
                ->orderBy('location_name ASC')
                ->all();        
    }
    
    
    /**
     * MAS activated products used
     * 
     * @param type $filtersArray
     * @param type $asArray% 
     */
    public function getActivatedProductsUsed($filtersArray, $asArray=true) {
        $whereArray = array(); $geozoneIds = array();

        if(array_key_exists('product_type', $filtersArray) && !empty($filtersArray['product_type'])) 
                $whereArray['product_type'] =  $filtersArray['product_type'];
        
        if(array_key_exists('product_id', $filtersArray) && !empty($filtersArray['product_id'])) 
                $whereArray['product_id'] = $filtersArray['product_id'];
        
        $fromDate = array_key_exists('from_date', $filtersArray) && !empty($filtersArray['from_date']) ? 
                $filtersArray['from_date'] : 
                $this->getEarliestReported()->date_reported;
        
        $toDate = array_key_exists('to_date', $filtersArray) && !empty($filtersArray['to_date']) ? 
                $filtersArray['to_date'] : 
                $this->getLastReported()->date_reported;
        
        //Denom: # of MAS requests received
        //Num: # of requests received on activated products
            
        $nums = UsageReport::find()
                    ->select(['COUNT(*) AS requests', 'date_reported', 'MONTHNAME(date_reported) AS month', 'batch.batch_number'])
                    ->innerJoinWith(['batch', 'batch.product', 'batch.product.productType', 'batch.product.provider'])
                    ->where($whereArray)
                    ->andWhere(['=', 'mas_code_status', 2])
                    ->andWhere(['between', 'date_reported', $fromDate, $toDate])
                    ->groupBy(['MONTH(date_reported)'])
                    ->indexBy('month')
                    ->asArray($asArray)
                    ->all();    
        
        $denoms = UsageReport::find()
                    ->select(['COUNT(*) AS requests', 'date_reported', 'MONTHNAME(date_reported) AS month', 'batch.batch_number'])
                    ->innerJoinWith(['batch', 'batch.product', 'batch.product.productType', 'batch.product.provider'])
                    ->where($whereArray)
                    ->andWhere(['between', 'date_reported', $fromDate, $toDate])
                    ->groupBy(['MONTH(date_reported)'])
                    ->indexBy('month')
                    ->asArray($asArray)
                    ->all();
        
        //remove keys not existing in both arrays
        foreach($denoms as $key=>$value){
            if(!array_key_exists($key, $nums))
                    unset($denoms[$key]);
        }
        
        $activatedPercentArray = [];
        foreach($nums as $key=>$monthDetails){
            //$month = date('F', strtotime($monthDetails['date_reported']));
            $activatedPercentArray[$key] = round($monthDetails['requests'] /$denoms[$key]['requests'] * 100, 1);
        }
        
        return $activatedPercentArray;
        
    }
    
    /**
     * % of requests that returned fake responses
     * 
     * @param type $filtersArray
     * @param type $asArray
     * @return array
     */
    public function percentageFakeResponses($filtersArray, $asArray=true){
        $whereArray = []; $geozoneIds = []; $location = new Location(); $providers = [];
        list($locationIDArray, $tiervalue) = Location::getGeoLevelData(
                array_key_exists('geozones', $filtersArray) ? json_decode($filtersArray['geozones']) : [],
                array_key_exists('states',$filtersArray) ? json_decode($filtersArray['states']) : [],
                array_key_exists('lgas',$filtersArray) ? json_decode($filtersArray['lgas']) : []
        ); 
        
        //echo empty(json_decode($filtersArray['providers'])); exit;
        
        if(array_key_exists('product_type', $filtersArray) && !empty($filtersArray['product_type'])) 
                $whereArray['product_type'] =  $filtersArray['product_type'];
        
        if(array_key_exists('providers', $filtersArray) && !empty(json_decode($filtersArray['providers']))) 
                $providers = json_decode($filtersArray['providers']);
        else 
                $providers = array_keys(Provider::find()->asArray()->indexBy('id')->all());
        
        //echo var_dump($providers); exit;
        
        $fromDate = array_key_exists('from_date', $filtersArray) && !empty($filtersArray['from_date']) ? 
                $filtersArray['from_date'] : 
                $this->getEarliestReported()->date_reported;
        
        $toDate = array_key_exists('to_date', $filtersArray) && !empty($filtersArray['to_date']) ? 
                $filtersArray['to_date'] : 
                $this->getLastReported()->date_reported;
        
        $tierText = $location->getTierText($tiervalue);
        $tierFieldName = $location->getTierFieldName($tiervalue);
        
        $nums = UsageReport::find()
                ->select(['COUNT(*) AS responses', $tierFieldName . ' AS location_name', 'batch.batch_number', 'location_id'])
                ->innerJoinWith(['batch', 'location', 'batch.product.productType', 'batch.product.provider'])
                ->where($whereArray)
                ->andWhere(['>', 'response', 1])
                ->andWhere(['in', 'provider_id', $providers])
                ->andWhere(['in', $tierText, $locationIDArray])
                ->andWhere(['between', 'date_reported', $fromDate, $toDate])
                ->indexBy('location_name')
                ->groupBy([$tierText])
                ->orderBy($tierText . ' ASC')
                ->asArray($asArray)
                ->all();  
        
        $denoms = UsageReport::find()
                    ->select(['COUNT(*) AS requests', $tierFieldName . ' AS location_name', 'batch.batch_number', 'location_id'])
                    ->innerJoinWith(['batch', 'location', 'batch.product.productType', 'batch.product.provider'])
                    ->where($whereArray)
                    ->andWhere(['in', 'provider_id', $providers])
                    ->andWhere(['in', $tierText, $locationIDArray])
                    ->andWhere(['between', 'date_reported', $fromDate, $toDate])
                    ->indexBy('location_name')
                    ->groupBy([$tierText])
                    ->orderBy($tierText . ' ASC')
                    ->asArray($asArray)
                    ->all();  
        
        //remove keys not existing in both arrays
        foreach($denoms as $key=>$value){
            if(!array_key_exists($key, $nums))
                    unset($denoms[$key]);
        }
        
        $fakeRespPercentages = array();
        foreach($nums as $key=>$value){
            $location = $nums[$key]['location_name'];
            $fakeRespPercentages[$location] = round(($nums[$key]['responses'] / $denoms[$key]['requests'] * 100), 1);
        }
        
        //var_dump($fakeRespPercentages); exit;
        return $fakeRespPercentages;
    }
}