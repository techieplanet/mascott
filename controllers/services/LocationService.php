<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\services;

use app\models\Location;
/**
 * Description of UsageReportService
 *
 * @author Swedge
 */
class LocationService {
    //put your code here
    
    /**
     * Putting this method here is a SW Eng. Concern., 
     * It could well have been inside a controller but 
     * putting in the Service Layer (a.k.a Service Layer)
     * permits us to be able to easily interface other applications with it.
     * If in a controller, it will not be reusable
     * If in a model, we cannot use the hierarchy result coming from model in other formats than JSON
     */
    public function getLocationsHierachyAsJson(){
        return json_encode(Location::getLocationsHierachy()); 
    }
    
    public function getSelectedLocationId($geozoneId, $stateId, $lgaId){
        if($lgaId > 0)
            return $lgaId;
        else if($stateId > 0)
            return $stateId;
        else if($geozoneId > 0)
            return $geozoneId;
        else 
            return 0;
    }
    
    public function traceSelectedLocationParents($location_id) {
        return json_encode(Location::traceLocationParents($location_id));
    }
}
