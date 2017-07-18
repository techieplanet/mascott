<?php

namespace app\models\reports;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductReport
 *
 * @author Swedge
 */


class ProductReport {
    //put your code here
    
    public function getReportWhereClause($filtersArray){
    //"MAS provider, Product name, Product type, Country of production, Dosage formulation; Activation status
//year -single selection
//Geographic location- multiple selection"
        
        $whereArray = array();
        if($filtersArray['provider_id'] > 0) $whereArray['provider_id'] = $filtersArray['provider_id'];
        if($filtersArray['product_name'] > 0) $whereArray['id'] = $filtersArray['product_name'];
        if($filtersArray['product_type'] > 0) $whereArray['product_type'] = $filtersArray['product_type'];
        if($filtersArray['production_country'] > 0) $whereArray['production_country'] = $filtersArray['production_country'];
        if($filtersArray['mas_code_status'] > 0) $whereArray['mas_code_status'] = $filtersArray['mas_code_status'];
        
        return $whereArray;
    }
}
