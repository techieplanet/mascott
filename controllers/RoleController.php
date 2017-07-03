<?php

namespace app\controllers;

use Yii;
use app\models\Role;
use app\models\RoleAcl;
use app\models\Permission;
use app\controllers\services\RoleService;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller
{
    public $service;
    
    
    public function init(){
        $this->service = new RoleService();
    }
    
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
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {        
        $roles = Role::find()->all();

        return $this->render('index', [
            'roles' => $roles,
        ]);
    }
    
    public function actionIndexGii()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Role::find(),
        ]);
        
        $roles = Role::find()->all();

        return $this->render('indexgii', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Role model.
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
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();
        $success = false;
        
        //load all permission and their actions
        $processedPermissions = $this->service->getEntitiesAndPermissions();
        $rolePermissions = array();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            $permissions = Yii::$app->request->post('Permission'); //permissions from from
            
            if(!empty($permissions)){
              foreach($permissions as $permissionId)  {
                  $roleAcl = new RoleAcl();
                  $roleAcl->role_id = $model->id;
                  $roleAcl->permission_id = $permissionId;
                  $roleAcl->save();
              }
            }
            
            $rolePermissions = $model->getPermissionIDs(); //get/load the permissions entered for the tole
            $success = true;
        } 
        
        return $this->render('create', [
            'model' => $model,
            'processedPermissions' => $processedPermissions,
            'rolePermissions' => $rolePermissions,
            'success' => $success
        ]);
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $success = false;
        
        //load all permission and their actions
        $processedPermissions = $this->service->getEntitiesAndPermissions();
        $rolePermissions = $model->getPermissionIDs(); //get/load the permissions entered for the role
        //var_dump($rolePermissions); exit;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            RoleAcl::deleteAll(['role_id' => $id]); //clear all permissions first 
            
            $permissions = Yii::$app->request->post('Permission'); //permissions from from
            //var_dump($permissions); exit;
            if(!empty($permissions)){
              foreach($permissions as $permissionId){
                  $roleAcl = new RoleAcl();
                  $roleAcl->role_id = $model->id;
                  $roleAcl->permission_id = $permissionId;
                  $roleAcl->save();
              }
            }
            
            $rolePermissions = $model->getPermissionIDs(); 
            $success = true;
        } 
        
        return $this->render('update', [
            'model' => $model,
            'processedPermissions' => $processedPermissions,
            'rolePermissions' => $rolePermissions,
            'success' => $success
        ]);
    }

    /**
     * Deletes an existing Role model.
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
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
