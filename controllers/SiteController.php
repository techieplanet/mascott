<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    
//    public function init(){
//        echo Yii::$app->getHomeUrl(); exit;
//        if(Yii::$app->user->isGuest);
//            //$this->goHome();
//    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'login'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {        
        //if logged in, redirect to dashboard page
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('site/dashboard');
        }
       
        $this->layout = 'centered';
        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $url = (isset($_GET['r']) && (!empty($_GET['r']))) ? $_GET['r'] : 'site/dashboard';
            return $this->redirect([$url]); //does Url::to([])
            
        }
        
        return $this->render('index',[
            'model' => $model
        ]);  
        
    }

    /**
     * This stands in for the dashoard for now
     */
    public function actionDashboard()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->render('dashboard');
        } else {
            $this->redirect('index');
        }
    }
    
    /**
     * Login action.
     * @return Response|string
     */
//    public function actionLogin()
//    {
//        echo 'inside login'; exit;
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }
//
//        $model = new LoginForm();
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        }
//        return $this->render('login', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function error(){
        
    }
}
