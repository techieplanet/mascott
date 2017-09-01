<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Role;
use app\models\Location;
use app\controllers\services\RoleService;
use app\controllers\services\UserService;
use app\controllers\services\ProviderService;
use app\models\utils\Trailable;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $dataProvider = new ActiveDataProvider([
//            'query' => User::find(),
//        ]);
        
        $users = User::find()->where(['deleted' => 0])->all();
        return $this->render('index', [
            'users' => $users,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
                
        try {
            $model = new User();
            //$success = false;
            //$selectedRoleId = 0; $selectedDesignation = '';
            $roleService = new RoleService();
            $userService = new UserService();
            $providerService = new ProviderService();
            
            $rolesMap = $roleService->getRolesMap(); $rolesMap[0] = '--Select Role--'; ksort($rolesMap);
            $providerMap = $providerService->getProviderMap(); $providerMap[0] = '--Select Provider--'; ksort($providerMap);
            $zonesMap = ['0'=>'--Select Zone--'] + Location::getTierLocationsAssocArray(1);
            
            //add generated fields
            $model->salt = $userService->generateRandomString(6);
            $model->tempPass = $userService->generateRandomString(6);
            $model->password = $userService->hashPassword($model->tempPass);
            $model->access_token = $userService->generateRandomString(15);
            
            (new Trailable($model))->registerInsert();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $success = true;
                //$selectedRoleId = $model->role_id;
                //$selectedDesignation = $model->designation;
                $userService->sendNewUserEmail($model);
                
                Yii::$app->session->setFlash('saved', 'CREATED');
                return $this->redirect(['update', 'id' => $model->id, 'new' => true]);
            }
                
            return $this->render('create', [
                'model' => $model,
                'rolesMap' => $rolesMap,
                'providerMap' => $providerMap,
                'zonesMap' => $zonesMap
            ]);
        } catch (Exception $e){
            echo $e->getMessage;
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $new = false) {
        try {
            $model = $this->findModel($id);
            //$success = false;
            //$selectedRoleId = 0; $selectedDesignation = '';
            $roleService = new RoleService();
            $userService = new UserService();
            $providerService = new ProviderService();
            
            $rolesMap = $roleService->getRolesMap(); $rolesMap[0] = '--Select Role--'; ksort($rolesMap);
            $providerMap = $providerService->getProviderMap(); $providerMap[0] = '--Select Provider--'; ksort($providerMap);
            $zonesMap = ['0'=>'--Select Zone--'] + Location::getTierLocationsAssocArray(1);
            
            $new == true ?  Yii::$app->session->setFlash('saved', Yii::$app->session->getFlash('saved')) : '';
            
            if ($model->load(Yii::$app->request->post())) {
                (new Trailable($model))->registerUpdate();
                if($model->save()) {
                    Yii::$app->session->setFlash('saved', 'UPDATED');
                    
                    if(Yii::$app->user->id == $model->id){
                        $model->setUpSessionVars();
                    }
                }
            }

            return $this->render('update', [
                'model' => $model,
                'rolesMap' => $rolesMap,
                'providerMap' => $providerMap,
                'zonesMap' => $zonesMap
            ]);
        } catch (Exception $e){
            echo $e->getMessage;
        }
    }

    
    
    /**
     * A logged in user changes his own profile
     * 
     * @param integer $id
     * @return mixed
     */
    public function actionProfile($id) {
        try {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                (new Trailable($model))->registerUpdate();
                if($model->save()) 
                    Yii::$app->session->setFlash('saved', 'UPDATED');
            }

            return $this->render('profile', [
                'model' => $model
            ]);
        } catch (Exception $e){
            echo $e->getMessage;
        }
    }
  
    
    
    /**
     * A logged in user changes his own profile
     * 
     * @param integer $id
     * @return mixed
     */
    public function actionChangePassword($id) {
        try {
            $model = $this->findModel($id);
            $model->scenario = User::CHANGE_PASSWORD_REQUIRED_SCENARIO;
            $userService = new UserService();
            
            if ($model->load(Yii::$app->request->post())) {
                $model->new_password = isset($_POST['User']['new_password']) ? $_POST['User']['new_password'] : '';
                $model->tempPass = isset($_POST['User']['tempPass']) ? $_POST['User']['tempPass'] : '';
                $model->new_password_repeat = isset($_POST['User']['new_password_repeat']) ? $_POST['User']['new_password_repeat'] : '';
                
                $model->scenario = User::CHANGE_PASSWORD_SCENARIO;
                
                /**
                 * THE SCENARIOS AND RULES DID NOT WORK.
                 * HAD TO ROLL MANUAL VALIDATION.
                 */
                if($model->validatePassword($model->tempPass) &&
                        ($model->new_password === $model->new_password_repeat)) {
                    $model->password = $userService->hashPassword($model->new_password);
                    if($model->save()){
                        Yii::$app->session->setFlash('changed', 'PASSWORD CHANGED');
                        return $this->redirect(['profile', 'id' => $model->id]);
                    } else {
                        Yii::$app->session->setFlash('changed_error', 'PASSWORD ERROR');
                    }
                } else {
                    Yii::$app->session->setFlash('changed_error', 'PASSWORD ERROR');
                }
                
            }

            return $this->render('change-password', [
                'model' => $model
            ]);
        } catch (Exception $e){
            echo $e->getMessage;
        }
    }
    
    
    
    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
