<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "location".
 *
 * @property integer $id
 * @property string $uuid
 * @property string $location_name
 * @property string $parent_id
 * @property integer $tier
 * @property integer $is_default
 * @property integer $geozone_id
 * @property integer $geozone_name
 * @property integer $state_id
 * @property integer $state_name
 * @property integer $lga_id
 * @property integer $lga_name
 * @property integer $modified_by
 * @property integer $created_by
 * @property integer $is_deleted
 * @property string $external_id
 *
 * @property UsageReport[] $usageReports
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location_name', 'tier'], 'required'],
            [['parent_id', 'tier', 'is_default', 'modified_by', 'created_by', 'is_deleted'], 'integer'],
            [['uuid'], 'string', 'max' => 36],
            [['location_name'], 'string', 'max' => 128],
            [['external_id'], 'string', 'max' => 20],
            [['uuid'], 'unique'],
            [['external_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'Uuid',
            'location_name' => 'Location Name',
            'parent_id' => 'Parent ID',
            'tier' => 'Tier',
            'is_default' => 'Is Default',
            'modified_by' => 'Modified By',
            'created_by' => 'Created By',
            'is_deleted' => 'Is Deleted',
            'external_id' => 'External ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsageReports()
    {
        return $this->hasMany(UsageReport::className(), ['location_id' => 'id']);
    }
    
    public function getChildren() {
        return $this->hasMany(Location::className(), ['parent_id' => 'id']);
    }
    
    public function getParent() {
        return $this->hasOne(Location::className(), ['id' => 'parent_id']);
    }
    
    public static function getTierLocations($tierId, $asArray=false) {
        return Location::find()
                ->where(['tier'=>$tierId])
                ->asArray($asArray)
                ->all();
    }
    
    
    public static function getTierLocationsAssocArray($tierId) {
        $zones = Location::find()
                ->where(['tier'=>$tierId])
                ->asArray()
                ->orderBy('location_name')
                ->all();
        
        return $zonesMap = ArrayHelper::map($zones, 'id', 'location_name');
    }
    
    public function getTierText($tierId){
        switch ($tierId){
            case 1: return 'geozone_id';
            case 2: return 'state_id';
            case 3: return 'lga_id';
        }
    }
    
    public function getTierFieldName($tierId){
        switch ($tierId){
            case 1: return 'geozone_name';
            case 2: return 'state_name';
            case 3: return 'lga_name';
        }
    }


    /**
     * 
     * @param type $id
     * @return array of containing IDs or 0 if no ID
     */
    public static function traceLocationParents($location_id) {
        $location = Location::findOne($location_id);
        
        if($location->tier == 1)
            return [$location->id, 0, 0];
        if($location->tier == 2)
            return [$location->parent->id, $location->id, 0];
        if($location->tier == 3)
            return [$location->parent->parent->id, $location->parent->id, $location->id];
    }
    
    
    /**
     * 
     * @param type $id
     * @return array of containing IDs or 0 if no ID
     */
    public static function getLocationTraceText($location_id) {
        $location = Location::findOne($location_id);
        $arr = array();
        
        if($location->tier == 1)
            $arr = [$location->location_name, 0, 0];
        if($location->tier == 2)
            $arr =  [$location->parent->location_name, $location->location_name, 0];
        if($location->tier == 3)
            $arr = [$location->parent->parent->location_name, $location->parent->location_name, $location->location_name];
        
        return $arr;
    }
    
    
    public static function getZoneChildrenHierachyAsArray($id) {
        return Location::find()
                ->select('id, location_name')
                ->where(['id' => $id])
                ->with('children.children')
                ->asArray()
                ->all();
    }
    
    /**
     * Gets all geolocation with their states nested 
     * And each state with their LGAs nested.
     * @return Array
     */
    public static function getLocationsHierachy(){
        //get geozones
        $geozones = Location::find()
                        ->where(['tier'=>1])
                        ->orderBy('location_name')
                        ->AsArray()
                        ->all();
        
        $locationsArray = array();
        
        foreach($geozones as $gz) {
            $lh = Location::getZoneChildrenHierachyAsArray($gz['id']);
            $gzid = $gz['id'].''; //use string key to be able to maintain array order.
            
            $locationsArray[$gzid] = array(
                'id' => $gz['id'],
                'location_name' => $gz['location_name'],
                'states' => ArrayHelper::map($lh[0]['children'], 'id', 'location_name')
            );
            
            //now treat states
            foreach($lh[0]['children'] as $key=>$state){
                $locationsArray[$gzid]['states'][$state['id']] = array(
                    'id' => $state['id'],
                    'location_name' => $state['location_name'],
                    'lgas' => ArrayHelper::map($lh[0]['children'][$key]['children'], ['id'], 'location_name')
                );
            }
        }
        
        return $locationsArray;
    }
    
    /*
     * This utility method will operate on the post array from form and 
     * derive the location ID list that will be used to call model report methods
     * LGA --> LGAs
     * States --> states
     * GPZ --> geozones
     */
    public static function getGeoLevelData($geozones, $states, $lgas){
        $selectionLimit = 6;
        $geoList='';
        $tierValue = 0;

        if(!empty($lgas)){
            if(count($lgas) > $selectionLimit) 
                $lgas = array_slice ($lgas, 0, $selectionLimit);
            $tierValue = 3;
            return array($lgas, $tierValue);
            
        } else if(!empty($states)) {
            if(count($states) > $selectionLimit) 
                $states = array_slice ($states, 0, $selectionLimit);
            $tierValue = 2;
            return array($states, $tierValue);

        } else if(!empty($geozones)) {
            if(count($geozones) > $selectionLimit) 
                $geozones = array_slice ($geozones, 0, $selectionLimit);
            $tierValue = 1;
            return array($geozones, $tierValue);
        }
        else { //no geo selection
            $tierValue = 1;
            $geozoneIds = array();
            $geoZones = Location::getTierLocations($tierValue); //geozones
            foreach($geoZones as $geoZone) 
                $geozoneIds[] = $geoZone->id;
            
            return array($geozoneIds, $tierValue);
            
        }
    }
      
      
    
    /**
     * One time script to set the geozone ID, state ID and LGA ID for each location
     * This wil help us to do report queries easily and faster.
     * Keep for reference and unforeseeable future need.
     */
    public static function setUp(){
        $location = new Location();
        $lhArray = Location::getLocationsHierachy();
        
        foreach($lhArray as $gz){
            $location = Location::findOne($gz['id']);
            $location->geozone_id = $gz['id'];
            $location->geozone_name = $gz['location_name'];
            $location->save();
            echo 'Saved GEOZONE: ' . $gz['id'];
            
            $states = $gz['states'];
            foreach($states as $state){
                $location = Location::findOne($state['id']);
                
                $location->geozone_id = $gz['id'];
                $location->geozone_name = $gz['location_name'];
                
                $location->state_id = $state['id'];
                $location->state_name = $state['location_name'];
                
                $location->save();
                
                $lgas = $state['lgas'];
                foreach($lgas as $lga_id=>$lga){
                    $location = Location::findOne($lga_id);
                    $location->geozone_id = $gz['id'];
                    $location->geozone_name = $gz['location_name'];
                    
                    $location->state_id = $state['id'];
                    $location->state_name = $state['location_name'];
                    
                    $location->lga_id = $lga_id;
                    $location->lga_name = $lga;
                    $location->save();
                }
                echo '<br/>Saved LGAs: ' . count($lgas);
                
            }
            echo '<br/>Saved STATES: ' . count($states);
            echo '<br/>---------------- COMPLETED ZONE: ' . $gz['location_name'] . ' ---------------------<br/><br/>';
        }
        
        echo '<br/><br/>COMPLETED';
    }
    
}