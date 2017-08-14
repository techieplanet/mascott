<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\web\Response;
use app\models\User;
use app\models\Location;
use app\models\UsageReport;
use app\models\Batch;
use app\models\utils\Trailable;

/**
 * Description of ReportController
 *
 * @author Swedge
 */
class ReportController extends ActiveController{
    //put your code here
    public $modelClass = 'app\models\User';
    private $_error = [];
    private $_user = null;
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];
        return $behaviors;
    }
    
    public function beforeAction($action){
        try {
            $user = User::findIdentityByAccessToken(isset($_GET['token']) ? $_GET['token'] : null);
            
            if($user === null){                
                $this->_error = $this->handleError(401);
                return true;
            }
            
            Yii::$app->user->login($user);
            return true;
            
        } catch(Exceptoin $e) {
            $this->_error = $this->handleError();
            return true;
        }
    }

    public function actionPush(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        //return json_encode(['jjj', 'kkk']);
        
        if(!empty($this->_error)) return $this->_error;  //ensure no error inside beforeAction
        
        try {
            $pname = isset($_GET['pname']) && !empty($_GET['pname']) ? $_GET['pname'] : '';
            $ptype = isset($_GET['ptype']) && !empty($_GET['ptype']) ? $_GET['ptype'] : '';
            $nrn = isset($_GET['nrn']) && !empty($_GET['nrn']) ? $_GET['nrn'] : '';
            $batchnum = isset($_GET['batchnum']) && !empty($_GET['batchnum']) ? $_GET['batchnum'] : '';
            $pin = isset($_GET['pin']) && !empty($_GET['pin']) ? $_GET['pin'] : '';
            $location = isset($_GET['location']) && !empty($_GET['location']) ? $_GET['location'] : '';
            $resp = isset($_GET['resp']) && !empty($_GET['resp']) ? $_GET['resp'] : '';
            $phone = isset($_GET['phone_num']) && !empty($_GET['phone_num']) ? $_GET['phone_num'] : '';
            $date_reported = isset($_GET['date_rep']) && !empty($_GET['date_rep']) ? $_GET['date_rep'] : '';

            if(empty($pname)) return $this->handleError(400, 'pname');
            if(empty($ptype)) return $this->handleError(400, 'ptype');
            if(empty($nrn)) return $this->handleError(400, 'nrn');
            if(empty($batchnum)) return $this->handleError(400, 'BN');
            if(empty($pin)) return $this->handleError(400, 'PIN');
            if(empty($location)) return $this->handleError(400, 'location');
            if(empty($resp)) return $this->handleError(400, 'resp');
            if(empty($phone)) return $this->handleError(400, 'BN');
            if(empty($date_reported))return $this->handleError(400, 'date reported');
            
            //ensure that the set of values matches a product, product type, NRN and batch number
            $batch = new Batch();
            if(!($batch->hasMatch($pname, $ptype, $nrn, $batchnum))){
                return $this->handleError(422);
                
            }

            //check if the location actually exists
            $locationId = Location::findOne(['UPPER(location_name)' => $location])->id;
            if(empty($locationId)) 
                return $this->handleError(422, 'Location not valid.');
            
            $inserted = $this->insert([
                'pname' => $pname, 
                'ptype' => $ptype, 
                'nrn' => $nrn, 
                'batchnum' => $batchnum, 
                'pin' => $pin, 
                'location' => $locationId, 
                'resp' => $resp,
                'phone' => $phone,
                'date_reported' => $date_reported
            ]);
            
            if($inserted) return ['Response Code' => 201, 'message' => 'Request Successful'];
            
        } catch(Exception $e) {
            $this->redirect(['error-handler?errorCode=500']);
        }
    }
    
    private function insert($data){
        $model = new UsageReport();
        
        $model->batch_number = $data['batchnum'];
        $model->pin_4_digits = $data['pin'];
        $model->location_id = $data['location']; ////////////////////////
        $model->response = $data['resp'];
        $model->phone = $data['phone'];
        $model->date_reported = $data['date_reported'];
        (new Trailable($model))->registerInsert();
        
        if(!$model->validate()){
            return $this->handleError(417);
        }
        else if($model->save()) {
            return $this->handleError(417, 'Not saved.');
        }
        
        return true;
    }
    
    public function handleError($errorCode=0, $message=''){      
        $error = '';
        
        switch($errorCode){
            case 400:
                $error = ['Error Code' =>$errorCode, 
                    'message' => empty($message) ? 'Bad Request. Check your parameters' : $message]; 
                break;
            case 401: 
                $error = ['Error Code' =>$errorCode, 'message' => empty($message) ? 'Unauthorized' : $message]; 
                break;
            case 417: 
                $error = ['Error Code' =>$errorCode, 'message' => empty($message) ? 'Validation failed. Check your paramenters' : $message]; 
                break;
            case 422: 
                $error = ['Error Code' =>$errorCode, 'message' => empty($message) ? 'No match found' : $message]; 
                break;
            case 500:
                $error = ['Error Code' =>500, 'message' => empty($message) ? 'Error Occured' : $message]; 
                break;
            default:
                $error = ['Error Code' =>500, 'message' => empty($message) ? 'Error Occured' : $message]; 
        }
        
        return $error;
    }
    
    public function logger($msg){
        file_put_contents('logger.txt', date('Y-m-d H:i:s') . ' ' . $msg, FILE_APPEND);
    }
}