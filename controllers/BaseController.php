<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * Description of BaseController
 *
 * @author Swedge
 */
class BaseController extends Controller {
    //put your code here
    
    public function beforeAction($action){
        if (Yii::$app->user->isGuest) {
            $this->redirect(['site/index?r='.$action->getUniqueId()]);
            return false;
        }
        
        return true;
    }
           
    /**
     * Checks for one of the permissions sent in the array
     * @param type $aliasList
     * @return boolean
     * @throws \yii\web\ForbiddenHttpException
     */
    public function checkPermission($aliasList){
        $permissions = Yii::$app->session['user_permissions'];
        
        foreach($aliasList as $alias) {
            if(in_array($alias, $permissions))
                return true;
        }
        
        throw new \yii\web\ForbiddenHttpException();
    }
    
    
    /**
     * Checks that all the permissions in the array are available for the user
     * @param type $aliasList
     * @return boolean
     * @throws \yii\web\ForbiddenHttpException
     */
    public function checkPermissions($aliasList){
        $permissions = Yii::$app->session['user_permissions'];
        
        foreach($aliasList as $alias) {
            if(!in_array($alias, $permissions))
                throw new \yii\web\ForbiddenHttpException();
        }
        
        return true;
    }
}
