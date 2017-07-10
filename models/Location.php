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
    
    /**
     * 
     * @param type $id
     * @return type
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
    
}
