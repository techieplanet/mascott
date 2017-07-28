<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Role;
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
                //'success' => $success,
                //'selectedRoleId' => $selectedRoleId,
                //'selectedDesignation' => $selectedDesignation
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

            $new == true ?  Yii::$app->session->setFlash('saved', Yii::$app->session->getFlash('saved')) : '';
            
            (new Trailable($model))->registerUpdate();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                //$success = true;
                //$selectedRoleId = $model->role_id;
                //$selectedDesignation = $model->designation;
                //return $this->redirect(['view', 'id' => $model->id]);
                Yii::$app->session->setFlash('saved', 'UPDATED');
            }

            return $this->render('update', [
                'model' => $model,
                'rolesMap' => $rolesMap,
                'providerMap' => $providerMap,
                //'success' => $success,
                //'selectedRoleId' => $selectedRoleId,
                //'selectedDesignation' => $selectedDesignation,
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
