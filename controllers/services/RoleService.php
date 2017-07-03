<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RoleService
 *
 * @author Swedge
 */
namespace app\controllers\services;

use app\models\Permission;
use app\models\RoleAcl;
use app\models\Role;
use yii\helpers\ArrayHelper;

class RoleService {
    
    /**
     * This method will get all entities in permissions table and the actions available to them
     * It arranges the result in the form array(entity1=>[...actions...], entity2=>[...actions...])
     * @return array(entity1=>[...actions...], entity2=>[...actions...])
     */
    public function getEntitiesAndPermissions(){
        $permissions = Permission::find()->orderBy('entity,weight')->all();
        
        $currentEntity = '';
        $result = array();
        
        foreach($permissions as $permission){
            if($currentEntity !== $permission->entity){
                $currentEntity = $permission->entity;
                $result[$currentEntity] = array();
            }
            
            $result[$currentEntity][] = $permission;
        }
        
        return $result;
    }
   
    
    /**
     * This method constructs a map of ID and Title 
     * @return array(id=>x, title=>y)
     */
    public function getRolesMap(){
        return ArrayHelper::map(Role::getRolesAsAssocArray(), 'id', 'title');
    }
}
