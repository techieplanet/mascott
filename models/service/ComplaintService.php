<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\service;

use Yii;

use app\models\Complaint;
use app\models\UsageReport;
use app\models\Location;
use app\models\Provider;
use app\models\Product;

/**
 * Description of ComplaintService
 *
 * @author Swedge
 */
class ComplaintService extends Complaint {    
    
    /**
     * % MAS requests confirmed counterfeits
     * 
     * @param type $filtersArray
     * @param type $asArray
     * @return array
     */
    public function getPercentageConfirmedCounterfeits($filtersArray, $asArray=true){
        //Product name, product type, Geographic location

        $whereArray = []; $geozoneIds = []; $providers = [];
        $location = new Location(); $usageReport = new UsageReport();
        
        $whereArray = self::myRoleACL();
        
        list($locationIDArray, $tiervalue) = Location::getGeoLevelData(
                array_key_exists('geozones', $filtersArray) ? json_decode($filtersArray['geozones']) : [],
                array_key_exists('states',$filtersArray) ? json_decode($filtersArray['states']) : [],
                array_key_exists('lgas',$filtersArray) ? json_decode($filtersArray['lgas']) : []
        ); 
                
        if(array_key_exists('product_type', $filtersArray) && !empty($filtersArray['product_type'])) 
                $whereArray['product_type'] =  $filtersArray['product_type'];
        
        if(array_key_exists('product_id', $filtersArray) && !empty($filtersArray['product_id'])) 
                $whereArray['product_id'] = $filtersArray['product_id'];
                
        $fromDate = array_key_exists('from_date', $filtersArray) && !empty($filtersArray['from_date']) ? 
                $filtersArray['from_date'] : 
                $usageReport->getEarliestReported()->date_reported;
        
        $toDate = array_key_exists('to_date', $filtersArray) && !empty($filtersArray['to_date']) ? 
                $filtersArray['to_date'] : 
                $usageReport->getLastReported()->date_reported;
        
        $tierText = $location->getTierText($tiervalue);
        $tierFieldName = $location->getTierFieldName($tiervalue);
        
        $nums = Complaint::find()
                    ->select(['COUNT(*) AS res_result', $tierFieldName . ' AS location_name', $tierText])
                    ->innerJoinWith(['report', 'report.location', 'report.batch.product', 'report.batch.product.productType'])
                    ->where($whereArray)
                    ->andWhere(['=', 'validation_result', 1])
                    ->andWhere(['in', $tierText, $locationIDArray])
                    ->andWhere(['between', 'date_reported', $fromDate, $toDate])
                    ->groupBy([$tierText, $tierFieldName])
                    ->orderBy($tierText . ' ASC')
                    ->asArray($asArray)
                    ->indexBy('location_name')
                    ->createCommand()
                    ->queryAll();
                    
        //change the keys to locations
        $nums = $this->changeKeys($nums, 'location_name');
        
        $denoms = UsageReport::find()
                    ->select(['COUNT(*) AS requests', $tierFieldName . ' AS location_name', $tierText])
                    ->innerJoinWith(['batch', 'location', 'batch.product.productType'])
                    ->where($whereArray)
                    ->andWhere(['in', $tierText, $locationIDArray])
                    ->andWhere(['between', 'date_reported', $fromDate, $toDate])
                    ->indexBy('location_name')
                    ->groupBy([$tierText, $tierFieldName])
                    ->orderBy($tierText . ' ASC')
                    ->asArray($asArray)
                    ->createCommand()
                    ->queryAll();  
        
        //change the keys to locations
        $denoms = $this->changeKeys($denoms, 'location_name');
        
        //remove keys not existing in both arrays
        foreach($denoms as $key=>$value){
            if(!array_key_exists($key, $nums))
                    unset($denoms[$key]);
        }
        
        $confirmedCounterfeitsPercentages = array();
        foreach($nums as $location=>$value){
            $confirmedCounterfeitsPercentages[$location] = 
                    round(($nums[$location]['res_result'] / $denoms[$location]['requests'] * 100), 1);
        }
        
        //var_dump($confirmedCounterfeitsPercentages); exit;
        return $confirmedCounterfeitsPercentages;
    }    
    
    
    /**
     * % of reported fake responses confirmed as counterfeits
     * Filters: Product name, product type
     * 
     * @param type $filtersArray
     * @param type $asArray
     * @return array
     */
    public function getPercentageFakeConfirmed ($filtersArray, $asArray=true){
        $whereArray = []; $geozoneIds = []; 
        $usageReport = new UsageReport();
                
        $whereArray = self::myRoleACL();
        
        if(array_key_exists('product_type', $filtersArray) && !empty($filtersArray['product_type'])) 
                $whereArray['product_type'] =  $filtersArray['product_type'];
        
        if(array_key_exists('product_id', $filtersArray) && !empty($filtersArray['product_id'])) 
                $whereArray['product_id'] = $filtersArray['product_id'];
        
        $fromDate = array_key_exists('from_date', $filtersArray) && !empty($filtersArray['from_date']) ? 
                $filtersArray['from_date'] : 
                $usageReport->getEarliestReported()->date_reported;
        
        $toDate = array_key_exists('to_date', $filtersArray) && !empty($filtersArray['to_date']) ? 
                $filtersArray['to_date'] : 
                $usageReport->getLastReported()->date_reported;
        
        $nums = Complaint::find()
                    ->select(['COUNT(*) AS res_result', 'MONTHNAME(date_reported) AS month', 'batch.batch_number', 'location_id'])
                    ->innerJoinWith(['report', 'report.location', 'report.batch.product', 'report.batch.product.productType'])
                    ->where($whereArray)
                    ->andWhere(['=', 'validation_result', 1])
                    ->andWhere(['between', 'date_reported', $fromDate, $toDate])
                    ->indexBy('month')
                    ->groupBy(['MONTH(date_reported)'])
                    ->orderBy('date_reported' . ' ASC')
                    ->asArray($asArray)
                    ->all();   
        
        $denoms = UsageReport::find()
                    ->select(['COUNT(*) AS responses', 'MONTHNAME(date_reported) AS month', 'batch.batch_number', 'location_id'])
                    ->innerJoinWith(['batch', 'location', 'batch.product.productType'])
                    ->where($whereArray)
                    ->andWhere(['>', 'response', 1])
                    ->andWhere(['between', 'date_reported', $fromDate, $toDate])
                    ->indexBy('month')
                    ->groupBy(['MONTH(date_reported)'])
                    ->orderBy('date_reported' . ' ASC')
                    ->asArray($asArray)
                    ->all();    
        
        //remove keys not existing in both arrays
        foreach($denoms as $key=>$value){
            if(!array_key_exists($key, $nums))
                    unset($denoms[$key]);
        }
        
        $fakeConfirmedPercentages = array();
        foreach($nums as $key=>$monthDetails){
            $fakeConfirmedPercentages[$key] = round($monthDetails['res_result'] /$denoms[$key]['responses'] * 100, 1);
        }
        
        //var_dump($fakeConfirmedPercentages); exit;
        return $fakeConfirmedPercentages;
    }    
    
    /**
     * Returns for all products if products list array is empty
     * 
     * @param type $productsList
     * @return type array
     */
    public function getCounterfeitsCountByProduct(){
        $productIDs = Product::find()->select('id')->asArray()->all();
        $productIDsArray = array();
        foreach($productIDs as $productID)
            $productIDsArray[] = $productID['id'];
        
        $roleConditionArray = self::myRoleACL();
        
        $complaints = Complaint::find()
                ->select(['count(product.id) AS fakesCount', 'product_name'])
                ->innerJoinWith(['report', 'report.batch.product'])
                ->where(['in', 'product.id', $productIDsArray])
                ->andWhere(['>', 'validation_result', 1])
                ->andWhere($roleConditionArray)
                ->asArray()
                ->indexBy('product_name')
                ->groupBy('product.id')
                ->orderBy('product_name')
                ->createCommand()
                ->queryAll();
        
        $complaints = $this->changeKeys($complaints, 'product_name');
        
        return $complaints;
    }
}
